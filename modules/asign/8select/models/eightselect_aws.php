<?php

require oxRegistry::getConfig()->getModulesDir().'asign/8select/ressources/aws.phar';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * 8select export
 *
 */
class eightselect_aws extends oxBase
{
    /**
     * @var string
     */
    static private $_sExportRemoteBucket = 's3://productfeed.8select.io/';

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
            // ToDo: set credentials for AWS
            $s3Client = new S3Client([
                'profile'     => 'default',
                'region'      => 'eu-central-1',
                'version'     => '2006-03-01',
                'credentials' => array(
                    'key'    => '',
                    'secret' => '',
                ),
            ]);
            $s3Client->putObject([
                'Bucket'     => self::$_sExportRemoteBucket,
                'Key'        => self::getRemotePath($sFeedId, $blFull) . basename($sSourceFile),
                'SourceFile' => $sSourceFile,
            ]);

            eightselect_export::clearExportLocalFolder($blFull);
        } catch (S3Exception $e) {
            // ToDo: logging
        }
    }

    private static function getRemotePath($sFeedId, $blFull)
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