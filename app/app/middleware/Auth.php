<?php
namespace Teknasyon\app\middleware;

use Teknasyon\Config\Input;
use Teknasyon\app\model\User;

class Auth{
    public static $user = null;
    public function not_login(){
        $headers=Input::headers();
        if(empty($headers['Token'])){
                return true;

        }
        return false;
    }
    public function check(){
        $headers=Input::headers();
        if(!empty($headers['Token'])){
            $user=new User();
            $tokenCheck=$user->loginControl([
                ['token', $headers['Token'] ,'=' ],
                ['user_status', 1, '=']
            ]);

            if(!empty($tokenCheck)){
                Self::$user = $tokenCheck;
                return true;
            }

            return [
                'type' => 'error',
                'message' => 'Token geçersiz'
            ];

        }
        return [
            'type' => 'error',
            'message' => 'Token gerekli'
        ];
    }
}