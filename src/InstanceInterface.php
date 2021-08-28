<?php

namespace Didytel\Ec2admin;

interface InstanceInterface
{
    /**
     * Get Ec2 instance ID
     * @return string The actual ID
     */
    public function getId(): string;

    /**
     * Set actual state of the instance
     * @param string $state The new state
     * @return Ec2
     */
    public function setState(string $state): InstanceInterface;

    /**
     * Get actual Ec2 instance state
     * @return string The current state
     */
    public function getState(): string;

}