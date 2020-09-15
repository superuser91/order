<?php

namespace ShippingService\Couriers;

class VNPost extends BaseCourier
{
    public function createShippingOrder()
    { }

    public function calculateShippingFee()
    {
        echo 'VNPost - ' . $_GET['data'];
    }
}
