<?php

namespace ShippingService\Contracts;

interface CourierInterface
{
    /**
     * Tính phí vận chuyển đơn hàng 
     */
    public function calculateShippingFee();

    /**
     * Tạo đơn vận chuyển
     */
    public function createShippingOrder();

}
