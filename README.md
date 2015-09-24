AWS S3 plugin for Kanboard
==========================

This plugin stores uploaded files to Amazon S3 instead of storing files on the local filesystem.

Author
------

- Frederic Guillot
- License MIT

Installation
------------

Amazon configuration:

- With the Amazon Web Services console, create a new bucket for Kanboard

Plugin installation:

- Create a folder **plugins/S3**
- Copy all files under this directory

Add those config parameters in your `config.php`:

```php
define('AWS_KEY', 'YOUR_API_KEY');
define('AWS_SECRET', 'YOUR_API_SECRET');
define('AWS_S3_BUCKET', 'YOUR_BUCKET_NAME');
define('AWS_S3_REGION', 'us-east-1'); // Define your bucket region
```
