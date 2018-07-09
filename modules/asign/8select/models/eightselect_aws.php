<?php

require oxRegistry::getConfig()->getModulesDir() . 'asign/8select/ressources/aws.phar';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * 8select export
 *
 */
class eightselect_aws extends oxBase
{
    CONST CREDENTIAL_PROD_BUCKET_URL = 's3://productfeed.8select.io/';
    CONST CREDENTIAL_PROD_KEY = '';
    CONST CREDENTIAL_PROD_SEC = '';
    CONST CREDENTIAL_INT_BUCKET_URL = 's3://productfeed-prod.staging.8select.io';
    CONST CREDENTIAL_INT_KEY = 'AKIAJ4UUWOTQYISENBIQ';
    CONST CREDENTIAL_INT_SEC = 'Z/H1pgky4/5b/6t8tUhTS12YpRZ5mKNPDPBH2IPa';

    /**
     * @var string
     */
    static private $_sExportRemotePath = '#FEEDID#/#FEEDTYPE#/#YEAR#/#MONTH#/#DAY#/';

    /**
     * @param string $sSourceFile
     * @param string $sFeedId
     * @param bool $blFull
     */
    public static function upload($sSourceFile, $sFeedId, $blFull)
    {
        try {
            $s3Client = new S3Client([
                'profile'     => 'default',
                'region'      => 'eu-central-1',
                'version'     => '2006-03-01',
                'credentials' => array(
                    'key'    => self::_getCredentialKey(),
                    'secret' => self::_getCredentialSecret(),
                ),
            ]);
            $s3Client->putObject([
                'Bucket'     => self::_getBucketUrl(),
                'Key'        => self::_getRemotePath($sFeedId, $blFull) . basename($sSourceFile),
                'SourceFile' => $sSourceFile,
            ]);

            eightselect_export::clearExportLocalFolder($blFull);
        } catch (S3Exception $e) {
            // ToDo: logging
        }
    }

    /**
     * return string
     */
    private static function _getBucketUrl()
    {
        if (eightselect_export::isProduction()) {
            self::CREDENTIAL_PROD_BUCKET_URL;
        } else {
            self::CREDENTIAL_INT_BUCKET_URL;
        }
    }

    /**
     * return string
     */
    private static function _getCredentialKey()
    {
        if (eightselect_export::isProduction()) {
            self::CREDENTIAL_PROD_KEY;
        } else {
            self::CREDENTIAL_INT_KEY;
        }
    }

    /**
     * return string
     */
    private static function _getCredentialSecret()
    {
        if (eightselect_export::isProduction()) {
            self::CREDENTIAL_PROD_SEC;
        } else {
            self::CREDENTIAL_INT_SEC;
        }
    }

    /**
     * return string
     */
    private static function _getRemotePath($sFeedId, $blFull)
    {
        $aParams = [
            '#FEEDID#'   => $sFeedId,
            '#FEEDTYPE#' => $blFull ? 'product_feed' : 'property_feed',
            '#YEAR#'     => date('Y'),
            '#MONTH#'    => date('m'),
            '#DAY#'      => date('d'),
        ];

        $sPath = str_replace(array_keys($aParams), $aParams, self::$_sExportRemotePath);
        return $sPath;
    }
}