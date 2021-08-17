<?php

namespace task4\task4;

interface IDelivery
{
    public function GetCost();
    public function GetDeliveryDays();
    public function GetDeliveryData();
}