<?php

namespace Kanboard\Plugin\S3;

require_once __DIR__.'/vendor/aws-autoloader.php';

use Kanboard\Core\ObjectStorage\ObjectStorageInterface;
use Kanboard\Core\ObjectStorage\ObjectStorageException;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\Credentials;

/**
 * S3 storage driver
 *
 * @package objectStorage
 * @author Frederic Guillot
 */
class S3Storage implements ObjectStorageInterface
{
    /**
     * @var S3Client
     */
    private $client;

    /**
     * @var string
     */
    private $bucket;

    /**
     * Constructor
     *
     * @access public
     * @param  string  $key      AWS API Key
     * @param  string  $secret   AWS API Secret
     * @param  string  $region   AWS S3 Region
     * @param  string  $bucket   AWS S3 bucket
     */
    public function __construct($key, $secret, $region, $bucket)
    {
        $this->bucket = $bucket;
        $credentials = new Credentials($key, $secret);

        $this->client = S3Client::factory(array(
            'credentials' => $credentials,
            'region' => $region,
            'version' => '2006-03-01',
        ));
    }

    /**
     * Fetch object contents
     *
     * @access public
     * @param  string  $key
     * @return string
     * @throws ObjectStorageException
     */
    public function get($key)
    {
        try {

            $result = $this->client->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $key,
            ));

            return $result['Body'];
        } catch (S3Exception $e) {
            throw new ObjectStorageException($e->getMessage());
        }
    }

    /**
     * Save object
     *
     * @access public
     * @param  string  $key
     * @param  string  $blob
     * @return boolean
     * @throws ObjectStorageException
     */
    public function put($key, &$blob)
    {
        try {

            $this->client->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $key,
                'Body' => $blob,
            ));

        } catch (S3Exception $e) {
            throw new ObjectStorageException($e->getMessage());
        }

        return true;
    }

    /**
     * Output directly object content
     *
     * @access public
     * @param  string  $key
     */
    public function output($key)
    {
        echo $this->get($key);
    }

    /**
     * Move local file to object storage
     *
     * @access public
     * @param  string  $filename
     * @param  string  $key
     * @return boolean
     * @throws ObjectStorageException
     */
    public function moveFile($filename, $key)
    {
        try {

            $this->client->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $key,
                'SourceFile' => $filename,
            ));

            @unlink($filename);

        } catch (S3Exception $e) {
            throw new ObjectStorageException($e->getMessage());
        }

        return true;
    }

    /**
     * Move uploaded file to object storage
     *
     * @access public
     * @param  string  $filename
     * @param  string  $key
     * @return boolean
     */
    public function moveUploadedFile($filename, $key)
    {
        return $this->moveFile($filename, $key);
    }

    /**
     * Remove object
     *
     * @access public
     * @param  string  $key
     * @return boolean
     * @throws ObjectStorageException
     */
    public function remove($key)
    {
        try {

            $this->client->deleteObject(array(
                'Bucket' => $this->bucket,
                'Key' => $key,
            ));

        } catch (S3Exception $e) {
            throw new ObjectStorageException($e->getMessage());
        }

        return true;
    }
}
