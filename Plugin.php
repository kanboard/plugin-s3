<?php

namespace Plugin\S3;

use Core\Plugin\Base;

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
}
