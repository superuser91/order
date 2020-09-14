<?php

namespace ShippingService\Couriers;

class VnPost extends BaseCourier
{
    public function createShippingOrder()
    { }

    public function calculateOrderFee()
    {
        echo 'VNPost - ' . $_GET['data'];
    }
}
