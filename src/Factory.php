<?php

namespace Didytel\Ec2admin;

class Factory
{
    public static function create($instanceId): Admin
    {
        $ec2 = new Ec2($instanceId);
        $ec2admin = new Admin($ec2);

        return $ec2admin;
    }
}