<?php

namespace task4\task4;

use Exception;
use task4\task4\IDelivery;

class BirdIDelivery implements IDelivery
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

    public function GetCost()
    {
        try {
            $cost = $this->params['weight'] * $this->params['height'] * $this->params['width'] * $this->params['length'] * 0.2;
        } catch (Exception $e) {
            return $e->getMessage('Невозможно рассчитать стоимость. Неверные параметры');
        }

        return $cost;
    }

    public function GetDeliveryDays()
    {
        foreach ($this->GetDeliveryData() as $address_from => $value) {
            if ($address_from == $this->sender_address) {
                foreach ($value as $address_to => $days) {
                    if ($address_to == $this->receive_address) {
                        return $days;
                    }
                }
            }
        }
    }

    public function GetDeliveryData()
    {
        return [
            'Москва'=>[
                    'Санкт-Петербург'=>2,
                    'Саратов' => 3
            ],
            'Санкт-Петербург' => [
                'Москва'  => 2,
                'Cаратов' => 4,
            ]
        ];
    }
}