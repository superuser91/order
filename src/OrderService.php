<?php

namespace ShippingService;

use Exception;
use GuzzleHttp\Psr7\Response;

class OrderService extends BaseOrderService
{
    /**
     * Lưu đơn hàng đã đặt thành công với đơn vị giao hàng vào csdl
     */
    public function saveCreatedShippingOrder(Response $response)
    {
        if (!isset($_POST['shop_id']) || !isset($_POST['date_booking']) || !isset($_POST['time_booking'])) {
            throw new Exception("Missing required field(s)");
        }

        $shop_id = $_REQUEST['shop_id'];
        $user_id = $_REQUEST['user_id'];
        $date_booking = $_POST['date_booking'];
        $time_booking = $_POST['time_booking'];
        $promotion_code = $_POST['promotion_code'];
        $is_receive = $_POST['is_receive'];
        $payment = $_POST['payment'];
        $note = $_POST['note'];
        $ship_id = $_POST['ship_id'];
        $address = $_POST['address'];
        $ship_code = $_POST['ship_code'];
        $user_name = $_POST['user_name'];
        $user_phone = $_POST['user_phone'];
        $user_address = $_POST['user_address'];
        $city_id = $_POST['city_id'];
        $district_id = $_POST['district_id'];
        $point_payment = $_POST['point'];
        $time_id = $_POST['time_id'];
        $list_product = $this->businessModel->getProductShopCart($user_id, $shop_id);
        if ($list_product) {
            foreach ($list_product as $key => $value) {
                $total_money += $value['price'] * $value['number'];
            }
        }
        $ship = $this->businessModel->getInfoById($ship_id, $table_ship = "shiper");
        $ship_money = $ship['price'];
        $promotion = $this->businessModel->getPromotionByCode($promotion_code);
        $promotion_value = $promotion['value'];
        $code = "VCB" . time();
        $point = $total_money / 1000;
        $table_product = "product";
        if ($payment == 3) {
            $check_point = $this->businessModel->checkPoint($user_id, $shop_id);
            if (!$check_point || $check_point['point'] < $point) {
                $errorId = 404;
                $message = "Bạn không đủ điểm";
                $result = null;
                return array(
                    "data" => $result,
                    "errorId" => $errorId,
                    "message" => $message
                );
            }
            $insert = array(
                "user_id" => $user_id,
                "code" => $code,
                "shop_id" => $shop_id,
                "address" => $address,
                "date_booking" => $date_booking,
                "time_booking" => $time_booking,
                "promotion_code" => $promotion_code,
                "is_receive" => $is_receive,
                "payment" => $payment,
                "note" => $note,
                "ship_id" => $ship_id,
                "ship_code" => $ship_code,
                "ship_money" => $ship_money,
                "total_money" => $total_money,
                "promotion_value" => $promotion_value,
                "user_name" => $user_name,
                "user_phone" => $user_phone,
                "user_address" => $user_address,
                "city_id" => $city_id,
                "point" => $point_payment,
                "time_id" => $time_id,
                "district_id" => $district_id
            );
            $table = "booking";
            $booking_id = $this->businessModel->insertCMS($table, $insert);
            $result = array(
                "booking_id" => $booking_id,
                "code" => $code
            );
            $where = "user_id = $user_id AND shop_id = $shop_id";
            $this->businessModel->deleteCMS($table = "product_cart", $where);
            if ($list_product) {
                foreach ($list_product as $key => $value) {
                    $insert = array(
                        "booking_id" => $booking_id,
                        "product_id" => $value['product_id'],
                        "number" => $value['number'],
                        "user_id" => $user_id,
                        "price" => $value['price']
                    );
                    $table = "product_booking";
                    $this->businessModel->insertCMS($table, $insert);
                    $product_id = $value['product_id'];
                    $product_detail = $this->businessModel->getInfoById($product_id, $table_product);
                    $number_sales = $product_detail['number_sales'] + $value['number'];
                    $update_number = array(
                        "number_sales" => $number_sales
                    );
                    $this->businessModel->updateCMS($table_product, $update_number, $where = "id = $product_id");
                }
            }
            $point_update = $check_point['point'] - $point;
            $update = array(
                "point" => $point_update
            );
            $table = "user_point";
            $this->businessModel->updateCMS($table, $update, $where = "user_id = $user_id AND shop_id = $shop_id");
            $content = "Thanh toán đơn hàng " . $code;
            $insert = array(
                "point" => $point,
                "user_id" => $user_id,
                "shop_id" => $shop_id,
                "content" => $content,
                "type" => 2
            );
            $table = "point_history";
            $this->businessModel->insertCMS($table, $insert);
        } else {
            $insert = array(
                "user_id" => $user_id,
                "code" => $code,
                "shop_id" => $shop_id,
                "date_booking" => $date_booking,
                "time_booking" => $time_booking,
                "promotion_code" => $promotion_code,
                "is_receive" => $is_receive,
                "payment" => $payment,
                "address" => $address,
                "note" => $note,
                "ship_id" => $ship_id,
                "ship_code" => $ship_code,
                "ship_money" => $ship_money,
                "total_money" => $total_money,
                "promotion_value" => $promotion_value,
                "user_name" => $user_name,
                "user_phone" => $user_phone,
                "user_address" => $user_address,
                "city_id" => $city_id,
                "point" => $point_payment,
                "time_id" => $time_id,
                "district_id" => $district_id
            );
            $table = "booking";
            $booking_id = $this->businessModel->insertCMS($table, $insert);
            $result = array(
                "booking_id" => $booking_id,
                "code" => $code
            );
            $where = "user_id = $user_id AND shop_id = $shop_id";
            $this->businessModel->deleteCMS($table = "product_cart", $where);
            if ($list_product) {
                foreach ($list_product as $key => $value) {
                    $insert = array(
                        "booking_id" => $booking_id,
                        "product_id" => $value['product_id'],
                        "number" => $value['number'],
                        "user_id" => $user_id,
                        "price" => $value['price']
                    );
                    $table = "product_booking";
                    $this->businessModel->insertCMS($table, $insert);
                    $product_id = $value['product_id'];
                    $product_detail = $this->businessModel->getInfoById($product_id, $table_product);
                    $number_sales = $product_detail['number_sales'] + $value['number'];
                    $update_number = array(
                        "number_sales" => $number_sales
                    );
                    $this->businessModel->updateCMS($table_product, $update_number, $where = "id = $product_id");
                }
            }
        }

        if ($payment != 3) {
            $content = "Mua đơn hàng " . $code;
            $insert = array(
                "point" => $point,
                "user_id" => $user_id,
                "shop_id" => $shop_id,
                "content" => $content,
                "type" => 1
            );
            $table = "point_history";
            $this->businessModel->insertCMS($table, $insert);
            $check_point = $this->businessModel->checkPoint($user_id, $shop_id);
            if (!$check_point) {
                $insert = array(
                    "point" => $point,
                    "user_id" => $user_id,
                    "shop_id" => $shop_id
                );
                $table = "user_point";
                $this->businessModel->insertCMS($table, $insert);
            } else {
                $point_update = $check_point['point'] + $point;
                $update = array(
                    "point" => $point_update
                );
                $table = "user_point";
                $this->businessModel->updateCMS($table, $update, $where = "user_id = $user_id AND shop_id = $shop_id");
            }
        }
        $errorId = 200;
        $message = "Success";
        return array(
            "data" => $result,
            "errorId" => $errorId,
            "message" => $message
        );
    }

    public function authenticate()
    {
        if (empty($_REQUEST['user_id'])) {
            throw new Exception("Missing user_id!");
        }
    }
}
