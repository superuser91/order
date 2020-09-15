<?php

namespace ShippingService\Couriers;

use Exception;

class CourierFactory
{
    const COURIER_NOT_FOUND = 1;

    public static function getCourier(String $courier): BaseCourier
    {
        switch ($courier) {
            case 'ghn':
                return new GiaoHangNhanh();
                break;
            case 'vnpost':
                return new VNPost();
                break;
            case 'ahamove':
                return new AhaMove();
                break;
            case 'ghtk':
                return new GiaoHangTietKiem();
                break;
            case 'lalamove':
                return new LaLaMove();
                break;
            case 'viettelpost':
                return new ViettelPost();
                break;
            default:
                throw new Exception("Courier not found", self::COURIER_NOT_FOUND);
                break;
        }
    }
}
