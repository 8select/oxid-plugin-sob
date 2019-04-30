<?php

/**
 * Product data API controller
 */
class eightselect_products_api extends oxUBase
{
    /** @var array */
    protected $fields;
    /** @var array */
    protected $requiredFields = [
        'oxarticles.OXID',
        'oxarticles.OXPARENTID',
        'oxarticles.OXARTNUM',
        'oxarticles.OXTITLE',
        'oxarticles.OXPIC1',
        'oxarticles.OXPIC2',
        'oxarticles.OXPIC3',
        'oxseo.URL',
    ];

    /**
     * Check credentials submitted in header
     */
    public function init()
    {
        parent::init();
        header("Content-Type: application/json; charset=utf-8");

        $error = new stdClass();
        $error->error = 'AUTH_ERROR';

        // First: Check if we even got those IDs configured
        $apiId = $this->getConfig()->getConfigParam('sEightSelectApiId');
        $feedId = $this->getConfig()->getConfigParam('sEightSelectFeedId');
        if (!$apiId || !$feedId) {
            header("HTTP/1.1 500 Internal Server Error");
            $error->message = 'credentials not configured';
            die(json_encode($error));
        }

        // Second: Check if the credentials were even sent
        $givenApiId = oxRegistry::get('oxUtilsServer')->getServerVar('HTTP_8SELECT_COM_TID');
        $givenFeedId = oxRegistry::get('oxUtilsServer')->getServerVar('HTTP_8SELECT_COM_FID');
        if (!$givenApiId || !$givenFeedId) {
            header("HTTP/1.0 404 Not Found");
            die(); // No output
        }

        // Third: Check if the given credentials match with ours
        if ($givenFeedId !== $feedId || $givenApiId !== $apiId) {
            header("HTTP/1.1 403 Forbidden");
            $error->message = 'credential mismatch';
            die(json_encode($error));
        }
    }

    /**
     * Loads all relevant data for response and outputs it
     *
     * @return null|void
     */
    public function render()
    {
        $response = new stdClass();
        $response->limit = $this->getLimit();
        $response->offset = $this->getOffset();
        $response->total = $this->getTotalArticlesSum();
        $response->data = $this->getData();

        die(json_encode($response));
    }

    /**
     * Endpoint listing all attributes/fields available for export
     */
    public function renderAttributes()
    {
        $data = oxRegistry::get('eightselect_attribute')->getAllFields();

        $response = new stdClass();
        $response->limit = count($data);
        $response->offset = 0;
        $response->total = count($data);
        $response->data = $data;

        die(json_encode($response));
    }

    /**
     * Endpoint listing all attributes/fields relevant for building variants
     */
    public function renderVariantDimensions()
    {
        $data = oxRegistry::get('eightselect_attribute')->getVarNames();

        $response = new stdClass();
        $response->limit = count($data);
        $response->offset = 0;
        $response->total = count($data);
        $response->data = $data;

        die(json_encode($response));
    }

    /**
     * Loads article data
     *
     * @return array
     */
    protected function getData()
    {
        $data = [];
        $view = getViewName('oxarticles');
        $limit = $this->getLimit();
        $offset = $this->getOffset();

        $fullExport = !$this->getConfig()->getRequestParameter('delta');

        $where = '';
        if (!$fullExport) {
            $log = oxNew('eightselect_log');
            $dateTime = $log->getLastSuccessExportDate($fullExport);
            if (!$dateTime) {
                $dateTime = date('Y-m-d H:i:s');
            }
            $dateTime = oxDb::getDb()->quote($dateTime);
            $where = "WHERE OXTIMESTAMP > $dateTime";
        }

        $requiredArticleFields = $this->getRequiredArticleFields();
        $query = "SELECT " . implode(', ', $requiredArticleFields) . " FROM $view $where LIMIT $offset, $limit";

        $articleData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getAll($query);
        foreach ($articleData as $article) {
            $data[] = $this->buildFullArticleData($article);
        }

        $fullExport = !$this->getConfig()->getRequestParameter('delta');
        $log = oxNew('eightselect_log');
        $log->setLastSuccessExportDate($fullExport);

        return $data;
    }

    /**
     * Collects required article fields from fields
     *
     * @return array
     */
    protected function getRequiredArticleFields()
    {
        $fields = $this->getFields();
        $requiredArticleFields = ['OXID', 'OXPARENTID', 'OXARTNUM', 'OXTITLE'];
        foreach ($fields as $fieldData) {
            list($table, $field) = explode('.', $fieldData['name']);

            if ($table === 'oxarticles') {
                $requiredArticleFields[] = $field;
            } elseif ($table === 'oxvarname') {
                $requiredArticleFields[] = 'OXVARNAME';
                $requiredArticleFields[] = 'OXVARSELECT';
            } elseif ($table === 'oxvendor') {
                $requiredArticleFields[] = 'OXVENDORID';
            } elseif ($table === 'oxmanufacturers') {
                $requiredArticleFields[] = 'OXMANUFACTURERID';
            }
        }

        return array_unique($requiredArticleFields);
    }

    /**
     * Merges article data with parent data and starts exporter
     *
     * @param array $articleData Article data
     * @return array
     */
    protected function buildFullArticleData($articleData)
    {
        // Merge parent data into variant data
        if ($articleData['OXPARENTID']) {
            $requiredArticleFields = $this->getRequiredArticleFields();
            $view = getViewName('oxarticles');
            $query = "SELECT " . implode(', ', $requiredArticleFields) . " FROM $view WHERE OXID = ?";
            $parentData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getRow($query, [$articleData['OXPARENTID']]);

            foreach ($articleData as $field => $value) {
                if (!$value && $parentData[$field]) {
                    $articleData[$field] = $parentData[$field];
                }
            }
        }

        $export = oxNew('eightselect_export');

        return $export->getExportData($this->getFields(), $articleData);
    }

    /**
     * Returns article limit for pagination
     *
     * @return int
     */
    protected function getLimit()
    {
        $limit = (int) $this->getConfig()->getRequestParameter('limit');
        if (!$limit) {
            $limit = 100;
        }

        return $limit;
    }

    /**
     * Returns offset for pagination
     *
     * @return int
     */
    protected function getOffset()
    {
        $offset = (int) $this->getConfig()->getRequestParameter('offset');
        if (!$offset) {
            $offset = 0;
        }

        return $offset;
    }

    /**
     * Returns number of all articles
     *
     * @return int
     */
    protected function getTotalArticlesSum()
    {
        $view = getViewName('oxarticles');

        return (int) oxDb::getDb()->getOne("SELECT COUNT(1) FROM $view");
    }

    /**
     * Returns requested/all fields
     *
     * @return array
     */
    protected function getFields()
    {
        if (is_null($this->fields)) {
            $data = oxRegistry::get('eightselect_attribute')->getAllFields();
            $fields = $data;
            if ($requestedFields = $this->getConfig()->getRequestParameter('fields')) {
                $fields = [];
                foreach ($data as $fieldData) {
                    if (in_array($fieldData['name'], $requestedFields, true)
                        || in_array($fieldData['name'], $this->requiredFields, true)
                    ) {
                        $fields[] = $fieldData;
                    }
                }
            }

            $this->fields = $fields;
        }

        return $this->fields;
    }
}
