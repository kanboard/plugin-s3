<?php

namespace Kanboard\Plugin\S3;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

defined('AWS_KEY') or define('AWS_KEY', '');
defined('AWS_SECRET') or define('AWS_SECRET', '');
defined('AWS_S3_BUCKET') or define('AWS_S3_BUCKET', '');
defined('AWS_S3_REGION') or define('AWS_S3_REGION', '');
defined('AWS_S3_PREFIX') or define('AWS_S3_PREFIX', '');

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
                    $this->getAwsPrefix()
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
        return '1.0.2';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-s3';
    }

    private function isConfigured()
    {
        if (!$this->getAwsAccessKey() || !$this->getAwsSecretKey() || !$this->getAwsRegion() || !$this->getAwsBucket()) {
            $this->logger->info('Plugin AWS S3 not configured!');
            return false;
        }

        return true;
    }

    private function getAwsAccessKey()
    {
        if (AWS_KEY) {
            return AWS_KEY;
        }

        return $this->configModel->get('aws_access_key_id');
    }

    private function getAwsSecretKey()
    {
        if (AWS_SECRET) {
            return AWS_SECRET;
        }

        return $this->configModel->get('aws_secret_access_key');
    }

    private function getAwsRegion()
    {
        if (AWS_S3_REGION) {
            return AWS_S3_REGION;
        }

        $configRegion = $this->configModel->get('aws_s3_region');
        if (!$configRegion) {
            return 'us-east-1';
        } else {
            return $configRegion;
        }
    }

    private function getAwsBucket()
    {
        if (AWS_S3_BUCKET) {
            return AWS_S3_BUCKET;
        }

        return $this->configModel->get('aws_s3_bucket');
    }

    private function getAwsPrefix()
    {
        if (AWS_S3_PREFIX) {
            return AWS_S3_PREFIX;
        }

        return $this->configModel->get('aws_s3_prefix');
    }
}
