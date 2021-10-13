<?php
namespace Teknasyon\app\controller;


use Teknasyon\Config\Controller;
use Teknasyon\Config\Input;
use Teknasyon\app\model\User;

class AuthController extends Controller{
    
    public function register(){
        $email=Input::post("email");
        $password=Input::post(("password"));
        $name=Input::post(("name")); 
        
        $user = new User();
        $registerControl=$user->registerControl([
            ['email',$email,'=']
        ]);
       
        if(!empty($registerControl)){
         return $this->json(['message'=>'Bu kullanıcı zaten var...']);
        }
        $insert=$user->userInsert([
            'email'=>$email,
            'password'=>md5($password),
            'name'=>$name,
            'token'=>md5(uniqid(mt_rand(), true))
        ]);
       /*burası çalışmıyor*/ 
         if(!empty($insert)){
             return $this->json(['message'=>"Kullanici kayidi yapildi..."]);
         }else{
             
             return $this->json(['message'=>"Bir hata oldu"],422);
         }
    }
    public function login(){
        $email=Input::post("email");
        $password=Input::post("password");
    
        $user=new User();
        $loginControl=$user->loginControl([
            ['email',$email,'='],
            ['password',md5($password),'=']
        ]);
    
        if($loginControl){
            $update_user=$user->update(
                'users',$loginControl->id,[
                'token'=>md5(uniqid(mt_rand(), true))
            ]);
            $update_user=$user->loginControl([
                ['id', $loginControl->id, '=']
            ]);
            return $this->json(['data'=>[
                'name'=>$update_user->name,
                'email'=>$update_user->email,
                'token'=>$update_user->token
            ]]);
            }
        return $this->json(['message'=> 'kullanıcı email veya şifre hatalı']);
    }
}