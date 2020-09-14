<?php

namespace ShippingService\Contracts;

interface ShippingServiceInterface
{
    public function calculateOrderFee();
    public function createOrder();
}
