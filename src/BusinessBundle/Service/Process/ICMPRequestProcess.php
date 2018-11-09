<?php

namespace BusinessBundle\Service\Process;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ICMPRequestProcess
{
    /**
     * @var bool
     */
    private $elasticUp;

    /**
     * @var string|string
     */
    private $elasticHost;

    /**
     * @var int|int
     */
    private $icmpPacketNumber;

    /**
     * ICMPRequestProcess constructor.
     * @param string $elasticHost
     * @param int $icmpPacketNumber
     */
    public function __construct(string $elasticHost, int $icmpPacketNumber)
    {
        $this->elasticHost = $elasticHost;
        $this->icmpPacketNumber = $icmpPacketNumber;
    }

    /**
     * @return bool
     */
    public function ping()
    {
        try {
            $process = new Process(array('ping', $this->elasticHost, '-c', $this->icmpPacketNumber));
            $process->mustRun();
            $this->setElasticUp(true);
        } catch (ProcessFailedException $exception) {
            $this->setElasticUp(false);
        }

        return $this->isElasticUp();
    }

    /**
     * @return bool
     */
    public function isElasticUp()
    {
        return $this->elasticUp;
    }

    /**
     * @param $elasticUp
     * @return $this
     */
    public function setElasticUp($elasticUp)
    {
        $this->elasticUp = $elasticUp;
        return $this;
    }
}