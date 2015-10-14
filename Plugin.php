<?php

namespace Kanboard\Plugin\S3;

use Kanboard\Core\Plugin\Base;

defined('AWS_KEY') or define('AWS_KEY', '');
defined('AWS_SECRET') or define('AWS_SECRET', '');
defined('AWS_S3_BUCKET') or define('AWS_S3_BUCKET', '');
defined('AWS_S3_REGION') or define('AWS_S3_REGION', 'us-east-1');

class Plugin extends Base
{
    public function initialize()
    {
        $this->container['objectStorage'] = function() {
            return new S3Storage(
                AWS_KEY,
                AWS_SECRET,
                AWS_S3_REGION,
                AWS_S3_BUCKET
            );
        };
    }

    public function getPluginName()
    {
        return 'AWS S3';
    }

    public function getPluginDescription()
    {
        return t('This plugin stores uploaded files to Amazon S3');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-s3';
    }
}
