<?php

namespace ShippingService\Couriers;

use Exception;
use ShippingService\Contracts\CourierInterface;

abstract class BaseCourier implements CourierInterface
{
    public function calculateShippingFee()
    {
        throw new Exception("This courirer is currently not support this function");
    }

    public function createShippingOrder()
    {
        throw new Exception("This courirer is currently not support this function");
    }
}
