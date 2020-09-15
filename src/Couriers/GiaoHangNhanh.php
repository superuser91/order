<?php

namespace ShippingService\Couriers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class GiaoHangNhanh extends BaseCourier
{
    const BASE_URL = 'https://dev-online-gateway.ghn.vn';

    public function calculateShippingFee(): Response
    {
        $url = self::BASE_URL . '/shiip/public-api/v2/shipping-order/fee';

        $token = 'a8959acb-f5e0-11ea-854a-465bc235df7b';

        $shopId = '74838';

        $client = new Client();

        $headers = [
            'Token' => $token,
            'Content-Type' => 'application/json',
            'ShopId' => $shopId,
            'debug' => true
        ];

        $data = [
            'shop_id' => (int) $_REQUEST['shop_id'],
            'service_id' => (int) $_REQUEST['service_id'],
            "service_type_id" => (int) $_REQUEST['service_type_id'],
            "to_district_id" => (int) $_REQUEST['to_district_id'],
            "to_ward_code" => (string) $_REQUEST['to_ward_code'],
            "height" => (int) $_REQUEST['height'],
            "length" => (int) $_REQUEST['length'],
            "weight" => (int) $_REQUEST['weight'],
            "width" => (int) $_REQUEST['width'],
            "insurance_fee" => (int) $_REQUEST['insurance_fee'],
            "coupon" => (string) $_REQUEST['coupon'],
        ];

        return $client->request(
            'POST',
            $url,
            [
                'json' => $data,
                'headers' => $headers,
            ],
        );
    }

    public function createShippingOrder(): Response
    {
        $client = new Client();

        $url = self::BASE_URL . '/shiip/public-api/v2/shipping-order/create';

        $token = 'a8959acb-f5e0-11ea-854a-465bc235df7b';

        $shopId = 74838;

        $headers = [
            'Token' => $token,
            'Content-Type' => 'application/json',
            'ShopId' => $shopId
        ];

        $data = array(
            "payment_type_id" => (int) $_REQUEST['payment_type_id'],
            "note" => (string) $_REQUEST['note'],
            "required_note" => (string) $_REQUEST['required_note'],
            "return_phone" => $_REQUEST['return_phone'],
            "return_address" => $_REQUEST['return_address'],
            "return_district_id" => (int) $_REQUEST['return_district_id'],
            "return_ward_code" => (string) $_REQUEST['return_ward_code'],
            "client_order_code" => $_REQUEST['client_order_code'],
            "to_name" => $_REQUEST['to_name'],
            "to_phone" => $_REQUEST['to_phone'],
            "to_address" => $_REQUEST['to_address'],
            "to_ward_code" => $_REQUEST['to_ward_code'],
            "to_district_id" => (int) $_REQUEST['to_district_id'],
            "cod_amount" => (int) $_REQUEST['cod_amount'],
            "content" => $_REQUEST['content'],
            "weight" => (int) $_REQUEST['weight'],
            "length" => (int) $_REQUEST['length'],
            "width" => (int) $_REQUEST['width'],
            "height" => (int) $_REQUEST['height'],
            "pick_station_id" => (int) $_REQUEST['pick_station_id'],
            "deliver_station_id" => (int) $_REQUEST['deliver_station_id'],
            "insurance_value" => (int) $_REQUEST['insurance_value'],
            "service_id" => (int) $_REQUEST['service_id'],
            "service_type_id" => (int) $_REQUEST['service_type_id'],
            "items" => json_decode($_REQUEST['items']),
        );

        return $client->request(
            'POST',
            $url,
            [
                'json' => $data,
                'headers' => $headers,
            ],
        );
    }
}
