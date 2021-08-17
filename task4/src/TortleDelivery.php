<?php

namespace task4\task4;

use task4\task4\DeliveryFactory;
use task4\task4\IDelivery;
use task4\task4\TortleIDelivery;

class TortleDelivery extends DeliveryFactory
{

    private $sender_address, $receive_address, $params;

    public function __construct(
        string $sender_address,
        string $receive_address,
        array $params
    ) {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
    }

    public function GetDelivery(): IDelivery
    {
        return new TortleIDelivery($this->sender_address, $this->receive_address, $this->params);
    }
}