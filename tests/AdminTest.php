<?php

namespace Tests;

use Aws\Credentials\Credentials;
use Didytel\Ec2admin\Factory;
use JmesPath\Env;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function setUp(): void
    {
        $instanceId = getenv("INSTANCE_ID");
        $this->assertNotEmpty($instanceId, "An instance id is not set in env.");
    }

    public function testCanGetInstanceState()
    {
        $instanceId = getenv("INSTANCE_ID");
        $ec2a = Factory::create($instanceId);
        $state = $ec2a->state()->getState();

        $this->assertSame("stopped", $state);
    }

    public function testCanStartInstance()
    {
        $instanceId = getenv("INSTANCE_ID");
        $ec2a = Factory::create($instanceId);
        $state = $ec2a->start()->state()->getState();

        $this->assertSame("pending", $state);
    }

    public function testCanStopInstance()
    {
        $instanceId = getenv("INSTANCE_ID");
        $ec2a = Factory::create($instanceId);
        $state = $ec2a->stop()->state()->getState();

        $this->assertSame("stopping", $state);
    }

    public function testCanGetInstanceStateCredentials()
    {
        $credentials = new Credentials(getenv("AWS_ACCESS_KEY_ID"), getenv("AWS_SECRET_ACCESS_KEY"));
        $instanceId = getenv("INSTANCE_ID");
        $ec2a = Factory::create($instanceId, $credentials);
    }
}