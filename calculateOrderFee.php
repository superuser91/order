<?php

use Exception;
use ShippingService\Couriers\Factory;
use ShippingService\ShippingService;

require_once __DIR__ . '/../../vendor/autoload.php';

if (empty($_GET['courier'])) {
    header('Content-Type: application/json; charset=utf-8', true, 400);
    echo json_encode([
        'success' => false,
        'msg' => "Missing courier!"
    ]);
    return;
}
try {
    $order = new ShippingService(Factory::getCourier($_GET['courier']));

    echo json_encode($order->calculateOrderFee());
} catch (\Throwable $e) {
    header('Content-Type: application/json; charset=utf-8', true, 400);
    echo json_encode([
        'success' => false,
        'msg' => $e->getMessage()
    ]);
}
