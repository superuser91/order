<?php

namespace ShippingService\Couriers;

class GiaoHangNhanh extends BaseCourier
{
    public function createShippingOrder()
    {
        return $_GET['data'];
    }

    public function calculateOrderFee()
    {
        return 'GHN - ' . $_GET['data'];
    }
}
