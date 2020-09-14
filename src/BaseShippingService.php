<?php

namespace ShippingService;

use ShippingService\Contracts\ShippingServiceInterface;
use ShippingService\Couriers\BaseCourier;

abstract class BaseShippingService implements ShippingServiceInterface
{
    protected $courier;
    public function __construct(BaseCourier $courier)
    {
        $this->courier = $courier;
    }

    final public function calculateOrderFee()
    {
        return $this->courier->calculateOrderFee();
    }

    final public function createOrder(){
        $createShippingOrderResponse = $this->courier->createShippingOrder();

        // $this->
    }
    
}
