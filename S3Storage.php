<?php

namespace Kanboard\Plugin\S3;

require_once __DIR__.'/vendor/aws-autoloader.php';

use Kanboard\Core\ObjectStorage\ObjectStorageInterface;
use Kanboard\Core\ObjectStorage\ObjectStorageException;
use Aws\S3\S3Client;
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
    private $bucket = '';

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * Constructor
     *
     * @access public
     * @param  string $key    AWS API Key
     * @param  string $secret AWS API Secret
     * @param  string $region AWS S3 Region
     * @param  string $bucket AWS S3 bucket
     * @param  string $prefix Object prefix
     */
    public function __construct($key, $secret, $region, $bucket, $prefix)
    {
        $this->bucket = $bucket;
        $credentials = new Credentials($key, $secret);

        $this->client = new S3Client([
            'credentials' => $credentials,
            'region' => $region,
            'version' => '2006-03-01',
        ]);

        $this->client->registerStreamWrapper();
        $this->prefix = $prefix;
    }

    /**
     * Fetch object contents
     *
     * @access public
     * @param  string  $key
     * @return string
     * @throws  ObjectStorageException
     */
    public function get($key)
    {
        $data = file_get_contents($this->getObjectPath($key));

        if ($data === false) {
            throw new ObjectStorageException('Object not found');
        }

        return $data;
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
        if (file_put_contents($this->getObjectPath($key), $blob) === false) {
            throw new ObjectStorageException('Unable to save object');
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
        readfile($this->getObjectPath($key));
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
        if (file_put_contents($this->getObjectPath($key), file_get_contents($filename)) === false) {
            throw new ObjectStorageException('Unable to upload file');
        }

        unlink($filename);
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
        return unlink($this->getObjectPath($key));
    }

    /**
     * Get object URL
     *
     * @access private
     * @param  string $key
     * @return string
     */
    private function getObjectPath($key)
    {
        return sprintf('s3://%s/%s%s', $this->bucket, $this->prefix !== '' ? $this->prefix.'/' : '', $key);
    }
}
