<?php

namespace Didytel\Ec2admin;

use Aws\Ec2\Ec2Client;

/** @package App\Instance */
class Admin
{
    private InstanceInterface $ec2;
    private Ec2Client $ec2client;

    public function __construct(InstanceInterface $ec2)
    {
        $this->ec2 = $ec2;
    }

    private function getClient()
    {
        if(!isset($this->ec2client)){
            $this->ec2client = new Ec2Client([
                'region' => 'eu-central-1',
                'version' => 'latest',
            ]); 
        }

        return $this->ec2client;
    }

    /**
     * Proceed with state retrieval and store in ec2 instance object
     * @return InstanceInterface Storage object
     */
    public function state()
    {
        $ec2Client = $this->getClient();
        $instanceState = ['internalError'];
        $result = $ec2Client->describeInstanceStatus([
            'InstanceIds' => [ $this->ec2->getId() ],
            'IncludeAllInstances' => true
        ]);
        $v = $result->hasKey("InstanceStatuses");
        if($v){
            $instanceState = $result->search("InstanceStatuses[*].InstanceState.Name");
        }

        $this->ec2->setState($instanceState[0]);

        return $this->ec2;
    }

    public function start(): Admin
    {
        $ec2Client = $this->getClient();
        $result = $ec2Client->startInstances([
            'InstanceIds' => [$this->ec2->getId()],
        ]);

        if($result->hasKey('StartingInstances')){
            $currentState = $result->search("StartingInstances[*].CurrentState.Name");
            $previousState = $result->search("StartingInstances[*].PreviousState.Name");
        }
        
        if($this->ec2->getState() != current($previousState)){
            $this->ec2->setState(current($currentState));
        }

        return $this;
    }

    public function stop(): Admin
    {
        $ec2Client = $this->getClient();
        $result = $ec2Client->stopInstances([
            'InstanceIds' => [$this->ec2->getId()],
        ]);

        if($result->hasKey('StoppingInstances')){
            $currentState = $result->search("StoppingInstances[*].CurrentState.Name");
            $previousState = $result->search("StoppingInstances[*].PreviousState.Name");
        }
        
        if($this->ec2->getState() != current($previousState)){
            $this->ec2->setState(current($currentState));
        }

        return $this;
    }
}
