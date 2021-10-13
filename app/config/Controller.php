<?php
namespace Teknasyon\Config;
class Controller{

    public static function json($data = array(),$status="200"){
        header("HTTP/1.1 $status Unauthorized");
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
