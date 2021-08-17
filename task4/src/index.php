<?php

require __DIR__ . '/../vendor/autoload.php';

use task4\task4\Delivery;

$delivery = new Delivery();

$delivery->GetDelivery('Москва','Санкт-Петербург', ['weight' => 2,'height' => 10, 'width' => 20, 'length' => 30]);