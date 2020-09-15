<?php

namespace ShippingService\Contracts;

interface OrderServiceInterface
{
    public function calculateShippingFee();
    public function createOrder();
}
