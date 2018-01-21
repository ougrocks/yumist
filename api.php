<?php
/**
 * Created by PhpStorm.
 * User: KThanksBye
 * Date: 7/17/2015
 * Time: 3:37 PM
 */
require_once 'rest.inc.php';
class API_Yumist extends REST {
    const hostname = "localhost";
    const username = "root";
    const password = "";
    const db_name = "yumist";
    private $db_result = null;
    public function __construct() {
        parent::__construct();
        $this->db_connect();
    }
    private function db_connect() {
        $this->db_result = mysql_connect(self::hostname,self::username,self::password);
        if($this->db_result) {
            mysql_select_db(self::db_name,$this->db_result);
        }
    }
    public function processApi() {
        $return_fun = strtolower(trim(str_replace("/","",$_REQUEST['request'])));
        if(method_exists($this,$return_fun) > 0) {
            $this->$return_fun();
        } else {
            $this->response(json_encode("Wrong Function Call"));
        }
    }
    public function get_user_details() {
        if($this->get_request() != "GET") {
            $this->response("Wrong Request");
        }
        $id = $this->request['id'];
        if(!empty($id)) {
            $query = "SELECT u.*, a.address_line_1,a.address_line_2,a.locality,a.city,a.state,a.pincode
                      FROM
                      (SELECT id as user_id,name,address_id,phone_no,created_timestamp,last_updated_timestamp
                      FROM
                      user
                      WHERE id = '$id')u, address a WHERE u.address_id = a.id";
            $result = mysql_query($query);
            $sum_result = array();
            if(mysql_num_rows($result) > 0) {
                while($row = mysql_fetch_assoc($result)) {
                    $sum_result[] = $row;
                }
                $this->response(json_encode($sum_result));
            } else {
                $this->request("No Content Found");
            }
        } else {
            $this->response("Id is blank");
        }
    }
    public function create_user() {
        if($this->get_request() != "POST") {
            $this->response("Wrong Request");
        }
        $user_name = $this->request['user_name'];
        $user_phone_no = $this->request['user_phone_no'];
        $address_line_1 = $this->request['address_line_1'];
        $address_line_2 = $this->request['address_line_2'];
        $locality = $this->request['locality'];
        $city = $this->request['city'];
        $state = $this->request['state'];
        $pincode = $this->request['pincode'];
        if(!empty($user_name) && !empty($user_phone_no) && !empty($address_line_1) && !empty($address_line_2) && !empty($locality) && !empty($city) && !empty($state) && !empty($pincode)) {
            $query_user = "INSERT INTO user VALUES(uuid(),'$user_name',uuid(),'$user_phone_no',NOW(),NOW())";
            $result_user = mysql_query($query_user);
            $query_address = "INSERT INTO address VALUES(uuid(),'$address_line_1', '$address_line_2','$locality','$city','$state','$pincode')";
            $result_address = mysql_query($query_address);
            if($result_address) {
                $this->response(json_encode("Value Inserted Successfully"));
            } else {
                $this->response(json_encode("Error in SQL Query"));
            }
        } else {
            $this->response(json_encode("Empty Fields"));
        }
    }
    public function update_user() {
        if($this->get_request() != "PUT") {
            $this->response("Wrong Request");
        }
        $id = $this->request['id'];
        $user_name = $this->request['user_name'];
        $user_phone_no = $this->request['user_phone_no'];
        if(!empty($id) && !empty($user_name) && !empty($user_phone_no)) {
            $query = "UPDATE user SET name = '$user_name', phone_no = '$user_phone_no' WHERE id = '$id'";
            $result = mysql_query($query);
            if($result) {
                $this->response(json_encode("Values Updated"));
            } else {
                $this->response(json_encode("SQL Error"));
            }
        } else {
            $this->response(json_encode("Empty Fields"));
        }
    }
    public function delete_user() {
        if($this->get_request() != "DELETE") {
            $this->response("Wrong Request");
        }
        $id = $this->request['id'];
        if(!empty($id)) {
            $query_get_address_id = mysql_query("SELECT address_id FROM user WHERE id = '$id'");
            $user_address_id = mysql_fetch_assoc($query_get_address_id);
            $address_id = $user_address_id["address_id"];
            $query = mysql_query("DELETE FROM user WHERE id = '$id'");
            $delete_address = mysql_query("DELETE FROM address WHERE id = '$address_id'");
            if($query && $delete_address) {
                $this->response(json_encode("ID: $id DELETED"));
            } else {
                $this->response(json_encode("SQL Error"));
            }
        } else {
            $this->response(json_encode("Empty Id Fields"));
        }
    }
    public function place_order() {
        if($this->get_request() != "POST") {
            $this->response("Wrong Request");
        }
        $order_name = $this->request['order_name'];
        $user_id = $this->request['user_id'];
        $meal_id = $this->request['meal_id'];
        if(!empty($order_name) && !empty($user_id) && !empty($meal_id)) {
            $insert_query = mysql_query("INSERT INTO orders VALUES(uuid(),'$order_name','$meal_id','$user_id','In Process',NOW(),NOW())");
            if($insert_query) {
                $this->response(json_encode("Order Placed"));
            } else {
                $this->response(json_encode("SQL ERROR"));
            }
        } else {
            $this->response(json_encode("Fields are Empty"));
        }
    }
    public function view_order() {
        if($this->get_request() != "GET") {
            $this->response("Wrong Request");
        }
        $id = $this->request['id'];
        if(!empty($id)) {
            $view_query = mysql_query("SELECT * FROM orders WHERE user_id = '$id'");
            $full_view = array();
            while($row = mysql_fetch_assoc($view_query)) {
                $full_view[] = $row;
            }
            $this->response(json_encode($full_view));
        }
        else {
            $this->response(json_encode("Empty Fields"));
        }
    }
    public function update_order() {
        if($this->get_request() != "PUT") {
            $this->response("Wrong Request");
        }
        $id = $this->request['id'];
        $order_name = $this->request['order_name'];
        $meal_id = $this->request['meal_id'];
        if(!empty($id) && !empty($order_name) && !empty($meal_id)) {
            $update_query = mysql_query("UPDATE orders SET name = '$order_name', meal_id = '$meal_id', last_updated_timestamp = NOW() WHERE id = '$id'");
            if($update_query) {
                $this->response(json_encode("Order Updated"));
            } else {
                $this->response(json_encode("SQL Error"));
            }
        } else {
            $this->response(json_encode("Empty Fields"));
        }
    }
    public function delete_order() {
        if($this->get_request() != "DELETE") {
            $this->response(json_encode("Wrong Request"));
        }
        $id = $this->request['id'];
        if(!empty($id)) {
            $delete_query = mysql_query("DELETE FROM orders WHERE id = '$id'");
            if($delete_query) {
                $this->response(json_encode("Id: $id DELETED"));
            } else {
                $this->response(json_encode("SQL Error"));
            }
        } else {
            $this->response(json_encode("Fields Empty"));
        }
    }
}
$api_call = new API_Yumist();
$api_call->processApi();