<?php

namespace Tests;

use Didytel\Ec2admin\Factory;
use JmesPath\Env;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
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
}