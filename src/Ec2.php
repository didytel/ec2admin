<?php

namespace Didytel\Ec2admin;

class Ec2 implements InstanceInterface
{
    private string $id;
    private string $state;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): Ec2
    {
        $this->state = $state;
        return $this;
    }
}