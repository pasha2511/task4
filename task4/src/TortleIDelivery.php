<?php

namespace task4\task4;

use DateTime;
use Exception;
use task4\task4\IDelivery;

class TortleIDelivery implements IDelivery
{

    private $sender_address, $receive_address, $params, $base_cost;

    public function __construct(
        string $sender_address,
        string $receive_address,
        array $params
    ) {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
        $this->base_cost = 150;
    }

    public function GetCost()
    {
        try {
            $sum = $this->params['weight'] + $this->params['height'] + $this->params['width'] + $this->params['length'];
            $mult = $this->params['weight'] * $this->params['height'] * $this->params['width'] * $this->params['length'];
            $koeff = round($sum / $mult * 100, 1);
        } catch (Exception $e) {
            return $e->getMessage('Невозможно рассчитать стоимость. Неверные параметры');
        }

        return $this->base_cost * $koeff;
    }
    public function GetDeliveryDays()
    {
        foreach ($this->GetDeliveryData() as $address_from => $value) {
            if ($address_from == $this->sender_address) {
                foreach ($value as $address_to => $days) {
                    if($address_to == $this->receive_address) {
                        return (new DateTime('+'.$days.' Day'))->format("d.m.Y");
                    }
                }
            }
        }
    }
    public function GetDeliveryData()
    {
        return [
            'Москва' => [
                'Санкт-Петербург' => 2,
                'Саратов' => 3
            ],
            'Санкт-Петербург' => [
                'Москва' => 2,
                'Cаратов' => 4,
            ]
        ];
    }
}