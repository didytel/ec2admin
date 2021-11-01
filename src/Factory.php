<?php

namespace Didytel\Ec2admin;

class Factory
{
    public static function create($instanceId, $credentials = null): Admin
    {
        $ec2 = new Ec2($instanceId);
        $ec2admin = new Admin($ec2, $credentials);

        return $ec2admin;
    }
}