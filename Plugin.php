<?php

namespace Kanboard\Plugin\S3;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

defined('AWS_KEY') or define('AWS_KEY', '');
defined('AWS_SECRET') or define('AWS_SECRET', '');
defined('AWS_S3_BUCKET') or define('AWS_S3_BUCKET', '');
defined('AWS_S3_REGION') or define('AWS_S3_REGION', '');
defined('AWS_S3_PREFIX') or define('AWS_S3_PREFIX', '');
defined('AWS_S3_OPTIONS') or define('AWS_S3_OPTIONS', '');

class Plugin extends Base
{
    public function initialize()
    {
        if ($this->isConfigured()) {
            $this->container['objectStorage'] = function() {
                return new S3Storage(
                    $this->getAwsAccessKey(),
                    $this->getAwsSecretKey(),
                    $this->getAwsRegion(),
                    $this->getAwsBucket(),
                    $this->getAwsPrefix(),
                    $this->getAwsOptions()
                );
            };
        }

        $this->template->hook->attach('template:config:integrations', 's3:config');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Amazon S3 Storage';
    }

    public function getPluginDescription()
    {
        return t('This plugin stores files to Amazon S3');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.5';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-s3';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }

    public function isConfigured()
    {
        if (!$this->getAwsAccessKey() || !$this->getAwsSecretKey() || !$this->getAwsRegion() || !$this->getAwsBucket()) {
            $this->logger->info('Plugin AWS S3 not configured!');
            return false;
        }

        return true;
    }

    public function getAwsAccessKey()
    {
        if (AWS_KEY) {
            return AWS_KEY;
        }

        return $this->configModel->get('aws_access_key_id');
    }

    public function getAwsSecretKey()
    {
        if (AWS_SECRET) {
            return AWS_SECRET;
        }

        return $this->configModel->get('aws_secret_access_key');
    }

    public function getAwsRegion()
    {
        if (AWS_S3_REGION) {
            return AWS_S3_REGION;
        }

        return $this->configModel->get('aws_s3_region');
    }

    public function getAwsBucket()
    {
        if (AWS_S3_BUCKET) {
            return AWS_S3_BUCKET;
        }

        return $this->configModel->get('aws_s3_bucket');
    }

    public function getAwsPrefix()
    {
        if (AWS_S3_PREFIX) {
            return AWS_S3_PREFIX;
        }

        return $this->configModel->get('aws_s3_prefix');
    }

    public function getAwsOptions()
    {
        if (AWS_S3_OPTIONS) {
            return json_decode(AWS_S3_OPTIONS, true);
        }

        return json_decode($this->configModel->get('aws_s3_options') ?: '{}', true);
    }
}
