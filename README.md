AWS S3 plugin for Kanboard
==========================

[![Build Status](https://travis-ci.org/kanboard/plugin-s3.svg?branch=master)](https://travis-ci.org/kanboard/plugin-s3)

This plugin stores uploaded files to Amazon S3 instead of storing files on the local filesystem.

Author
------

- Frederic Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.37
- PHP >= 5.5
- Account with Amazon AWS, or other S3 compatible service

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/S3`
3. Clone this repository into the folder `plugins/S3`

Note: Plugin folder is case-sensitive.

Configuration
-------------

You can configure this plugin through the user interface or with the config file. 
Use the config file if you don't want to store AWS credentials into the database.

### With the user interface

Go to **Settings > Integrations > Amazon S3 Storage**:

![s3](https://cloud.githubusercontent.com/assets/323546/15444333/64fdc1a4-1ebd-11e6-95d0-ec57a5b42afb.png)

### With the config file

Add those config parameters in your `config.php`:

```php
define('AWS_KEY', 'YOUR_API_KEY');
define('AWS_SECRET', 'YOUR_API_SECRET');
define('AWS_S3_BUCKET', 'YOUR_BUCKET_NAME');
define('AWS_S3_PREFIX', '');

// Set the region of your bucket
define('AWS_S3_REGION', 'us-east-1');

// Use AWS_S3_OPTIONS to configure custom end-point, like Minio
define('AWS_S3_OPTIONS', json_encode(['version' => 'latest', 'endpoint' => 'https://my.minio.io', 'use_path_style_endpoint' => true]));
```

### Notes

- If the S3 prefix is defined, all files will be save to `s3://YOUR_BUCKET/YOUR_PREFIX/path/to/object`.
