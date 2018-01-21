<?php
/**
 * Created by PhpStorm.
 * User: KThanksBye
 * Date: 7/17/2015
 * Time: 3:00 PM
 */
class REST {
    public $content_type = "application/json";
    public $request = array();
    public function __construct() {
        $this->inputs();
    }
    public function response($data) {
        $this->headers();
        echo $data;
    }
    public function headers(){
        header("Content-Type:".$this->content_type);
    }
    private function inputs() {
        switch($this->get_request()) {
            case "GET":
                $this->request = $this->sanitize($_GET);
                break;
            case "POST":
                $this->request = $this->sanitize($_POST);
                break;
            case "DELETE":
                $this->request = $this->sanitize($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"),$this->request);
                $this->request = $this->sanitize($this->request);
                break;
        }
    }
    private function sanitize($data){
        $sanitize_input = array();
        if(is_array($data)){
            foreach($data as $k => $v){
                $sanitize_input[$k] = $this->sanitize($v);
            }
        }else{
            if(get_magic_quotes_gpc()){
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $sanitize_input = trim($data);
        }
        return $sanitize_input;
    }
    public function get_request() {
        return $_SERVER["REQUEST_METHOD"];
    }
}