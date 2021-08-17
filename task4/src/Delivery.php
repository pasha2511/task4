<?php

namespace task4\task4;

use task4\task4\BirdDelivery;
use task4\task4\DeliveryFactory;
use task4\task4\TortleDelivery;

class Delivery
{

    public function GetDelivery(
        $sender_address,
        $receive_address,
        $params = [],
        $delivery_name = null
    ) {

        switch ($delivery_name) {
            case 'bird':
                $DeliveryData = $this->GetDeliveryFactory(new BirdDelivery($sender_address, $receive_address, $params));
                break;
            case 'tortle':
                $DeliveryData = $this->GetDeliveryFactory(new TortleDelivery($sender_address, $receive_address, $params));
                break;
            default:
                $DeliveryData = $this->GetAllDelivery($sender_address, $receive_address, $params);
        }

        echo json_encode($DeliveryData);
    }

    private function GetDeliveryFactory(DeliveryFactory $factory)
    {
        return $factory->GetResult();
    }

    private function GetAllDelivery($sender_address, $receive_address, $params)
    {
        $result[] = $this->GetDeliveryFactory(new BirdDelivery($sender_address, $receive_address, $params));
        $result[] = $this->GetDeliveryFactory(new TortleDelivery($sender_address, $receive_address, $params));

        return $result;
    }
}