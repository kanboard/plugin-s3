<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\S3\Plugin;

class PluginTest extends Base
{
    /**
     * @var Plugin
     */
    protected $plugin;

    public function setUp()
    {
        parent::setUp();
        $this->plugin = new Plugin($this->container);
    }

    public function testPlugin()
    {
        $this->assertSame(null, $this->plugin->initialize());
        $this->assertSame(null, $this->plugin->onStartup());
        $this->assertNotEmpty($this->plugin->getPluginName());
        $this->assertNotEmpty($this->plugin->getPluginDescription());
        $this->assertNotEmpty($this->plugin->getPluginAuthor());
        $this->assertNotEmpty($this->plugin->getPluginVersion());
        $this->assertNotEmpty($this->plugin->getPluginHomepage());
    }

    public function testIsConfigured()
    {
        $this->assertFalse($this->plugin->isConfigured());
    }

    public function testIsConfiguredWithAllValuesDefined()
    {
        $this->container['configModel']->save([
            'aws_access_key_id' => 'key',
            'aws_secret_access_key' => 'secret',
            'aws_s3_region' => 'region',
            'aws_s3_bucket' => 'bucket',
        ]);

        $this->assertTrue($this->plugin->isConfigured());
    }

    public function testGetAwsAccessKeyDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsAccessKey());
    }

    public function testGetAwsAccessKeyWithValueDefinedInDb()
    {
        $this->container['configModel']->save(['aws_access_key_id' => 'key']);
        $this->assertEquals('key', $this->plugin->getAwsAccessKey());
    }

    public function testGetAwsSecretKeyDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsSecretKey());
    }

    public function testGetAwsSecretKeyWithValueDefinedInDb()
    {
        $this->container['configModel']->save(['aws_secret_access_key' => 'secret']);
        $this->assertEquals('secret', $this->plugin->getAwsSecretKey());
    }

    public function testGetAwsRegionDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsRegion());
    }

    public function testGetAwsRegionWithValueDefinedInDb()
    {
        $this->container['configModel']->save(['aws_s3_region' => 'region']);
        $this->assertEquals('region', $this->plugin->getAwsRegion());
    }

    public function testGetAwsBucketDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsBucket());
    }

    public function testGetAwsBucketWithValueDefinedInDb()
    {
        $this->container['configModel']->save(['aws_s3_bucket' => 'bucket']);
        $this->assertEquals('bucket', $this->plugin->getAwsBucket());
    }

    public function testGetAwsPrefixDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsPrefix());
    }

    public function testGetAwsOptionsDefaultValue()
    {
        $this->assertEmpty($this->plugin->getAwsOptions());
    }

    public function testGetAwsPrefixWithValueDefinedInDb()
    {
        $this->container['configModel']->save(['aws_s3_prefix' => 'prefix']);
        $this->assertEquals('prefix', $this->plugin->getAwsPrefix());
    }
}
