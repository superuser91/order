<?php

namespace ShippingService;

use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use model\Admin;
use ShippingService\Contracts\OrderServiceInterface;
use ShippingService\Couriers\BaseCourier;
use Throwable;

abstract class BaseOrderService implements OrderServiceInterface
{
    protected $courier;
    protected $businessModel;

    public function __construct(BaseCourier $courier)
    {
        $this->authenticate();

        $this->courier = $courier;

        $this->businessModel = new Admin;
    }

    abstract public function authenticate();

    abstract public function saveCreatedShippingOrder(Response $response);

    final public function calculateShippingFee()
    {
        try {
            $calculateShippingFeeResponse = $this->courier->calculateShippingFee();

            return json_decode($calculateShippingFeeResponse->getBody());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody());
        }
    }

    final public function createOrder()
    {
        try {
            /**
             * Gọi API của nhà cung cấp dịch vụ giao hàng
             * Có thể bị Exception nếu HTTP Status là 400 hoặc 500
             */
            $createShippingOrderResponse = $this->courier->createShippingOrder();

            /**
             * Nếu gọi API bên trên thành công thì tiếp tục thực hiện lưu đơn hàng vào backend
             * Implement hàm saveCreatedShippingOrder() ở Class OrderService
             */
            $result = $this->saveCreatedShippingOrder($createShippingOrderResponse);

            return json_decode($createShippingOrderResponse->getBody());
        } catch (RequestException $e) {
            /**
             * Bắt Exception với HTTP Status là 400
             */
            return json_decode($e->getResponse()->getBody());
        } catch (Throwable $th) {
            /**
             * Bắt các trường hợp còn lại
             */
            return [
                'success' => false,
                'msg' => $th->getMessage()
            ];
        }
    }
}
