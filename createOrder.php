<?php

use ShippingService\Couriers\CourierFactory;
use ShippingService\OrderService;

require_once __DIR__ . '/../../vendor/autoload.php';

if (empty($_REQUEST['courier'])) {
    header('Content-Type: application/json; charset=utf-8', true, 400);
    echo json_encode([
        'success' => false,
        'code' => 400,
        'msg' => "Missing courier!"
    ]);
    return;
}
try {
    $order = new OrderService(CourierFactory::getCourier($_REQUEST['courier']));

    echo json_encode($order->createOrder());
} catch (\Throwable $e) {
    header('Content-Type: application/json; charset=utf-8', true, 400);
    echo json_encode([
        'success' => false,
        'code' => 400,
        'msg' => $e->getMessage()
    ]);
}
