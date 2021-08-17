<?php

namespace task4\task4;

use task4\task4\IDelivery;

abstract class DeliveryFactory
{

    abstract public function GetDelivery(): IDelivery;

    public function GetResult()
    {
        $delivery = $this->GetDelivery();
        $cost = $delivery->GetCost();
        $delivery_date = $delivery->GetDeliveryDays();

        return ['cost' => $cost, 'date' => $delivery_date];
    }
}