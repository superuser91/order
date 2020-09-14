<?php

namespace ShippingService\Couriers;

use Exception;

class Factory
{
    const COURIER_NOT_FOUND = 1;

    public static function getCourier(String $courier): BaseCourier
    {
        switch ($courier) {
            case 'ghn':
                return new GiaoHangNhanh();
                break;
            case 'vnpost':
                return new VnPost();
                break;
            default:
                throw new Exception("Courier not found", self::COURIER_NOT_FOUND);
                break;
        }
    }
}
