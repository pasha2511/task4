<?php

interface IDelivery{
 	public function getCost();
 	public function getDeliveryDays();
 	public function getDeliveryData();
}

abstract class DeliveryFactory{

	abstract public function getDelivery(): IDelivery;

	public function getResult()
    {
        $delivery = $this->getDelivery();
        $cost = $delivery->getCost();
        $delivery_date = $delivery->getDeliveryDays();

        return ['cost'=>$cost, 'date'=>$delivery_date];
    }
}

class BirdDelivery extends DeliveryFactory{


	private $sender_address, $receive_address, $params;

    public function __construct(string $sender_address, string $receive_address, array $params)
    {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
    }

    public function getDelivery(): IDelivery
    {
        return new BirdIDelivery($this->sender_address, $this->receive_address,$this->params);
    }
}

class BirdIDelivery implements IDelivery{

	private $sender_address, $receive_address, $params;

    public function __construct(string $sender_address, string $receive_address, array $params)
    {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
    }

    public function getCost(){
    	try{
    		$cost = $this->params['weight'] * $this->params['height'] * $this->params['width'] * $this->params['length'] * 0.2; 
    	}catch(Exception $e){
    		return $e->getMessage('Невозможно рассчитать стоимость. Неверные параметры');
    	}

    	return $cost;
    }
 	public function getDeliveryDays(){
 		foreach($this->getDeliveryData() as $address_from=>$value){
 			if($address_from == $this->sender_address){
 				foreach($value as $address_to=>$days){
 					if($address_to == $this->receive_address){
 						return $days;
 					}
 				}
 			}
 		}
 	}
 	public function getDeliveryData(){
 		return ['Москва'=>[
 							'Санкт-Петербург'=>2,
 							'Саратов' => 3
 						  ],
 			    'Санкт-Петербург' => [
 			    			'Москва'=> 2,
 			    			'Cаратов' => 4,
 			    		]
 				];
 	}
}

class TortleIDelivery implements IDelivery{

	private $sender_address, $receive_address, $params, $base_cost;

    public function __construct(string $sender_address, string $receive_address, array $params)
    {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
        $this->base_cost = 150;
    }

    public function getCost(){
    	try{
    		$koeff = round(($this->params['weight'] + $this->params['height'] + $this->params['width'] + $this->params['length'])/($this->params['weight'] * $this->params['height'] * $this->params['width'] * $this->params['length']) * 100, 1); 
    	}catch(Exception $e){
    		return $e->getMessage('Невозможно рассчитать стоимость. Неверные параметры');
    	}

    	return $this->base_cost * $koeff;
    }
 	public function getDeliveryDays(){
 		foreach($this->getDeliveryData() as $address_from=>$value){
 			if($address_from == $this->sender_address){
 				foreach($value as $address_to=>$days){
 					if($address_to == $this->receive_address){
 						return (new DateTime('+'.$days.' Day'))->format("d.m.Y");
 					}
 				}
 			}
 		}
 	}
 	public function getDeliveryData(){
 		return ['Москва'=>[
 							'Санкт-Петербург'=>2,
 							'Саратов' => 3
 						  ],
 			    'Санкт-Петербург' => [
 			    			'Москва'=> 2,
 			    			'Cаратов' => 4,
 			    		]
 				];
 	}
}

class TortleDelivery extends DeliveryFactory{

	private $sender_address, $receive_address, $params;

    public function __construct(string $sender_address, string $receive_address, array $params)
    {
        $this->sender_address = $sender_address;
        $this->receive_address = $receive_address;
        $this->params = $params;
    }

    public function getDelivery(): IDelivery
    {
        return new TortleIDelivery($this->sender_address, $this->receive_address,$this->params);
    }
}

class Delivery{
	
	private $deliveryFactory;
	
	public function getDelivery($sender_address, $receive_address, $params = [], $delivery_name = null){

		switch ($delivery_name) {
			case 'bird':
				$DeliveryData = $this->getDeliveryFactory(new BirdDelivery($sender_address, $receive_address, $params));
				break;

			case 'tortle':
				$DeliveryData = $this->getDeliveryFactory(new TortleDelivery($sender_address, $receive_address, $params));
				break;
			default:
				$DeliveryData = $this->getAllDelivery($sender_address, $receive_address, $params);

		}

		var_dump($DeliveryData);
	}

	private function getDeliveryFactory(DeliveryFactory $factory)
	{
    	return $factory->getResult();
	}

	private function getAllDelivery($sender_address, $receive_address, $params){
		$result[] = $this->getDeliveryFactory(new BirdDelivery($sender_address, $receive_address, $params));
		$result[] = $this->getDeliveryFactory(new TortleDelivery($sender_address, $receive_address, $params));

		return $result;
	}
}

$delivery = new Delivery();
$delivery->getDelivery('Москва','Санкт-Петербург',['weight'=>2,'height'=>10, 'width'=> 20, 'length'=>30]);