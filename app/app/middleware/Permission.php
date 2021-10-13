<?php
namespace Teknasyon\app\middleware;
use Teknasyon\app\model\Role;

class Permission{
    public function check(...$userPermissions){
      
        $role=new Role();
        $permissions=$role->UserRoles(Auth::$user->id);
        $const = [];
        foreach ($permissions as $key => $value) {
            $const[] = $value->const;
        }
        foreach ($userPermissions as $key => $value) {
            if(!in_array($value,$const)){
                return [
                    'type' => 'error',
                    'message' => 'Yetkiniz yok'
                ];
            }
        }
        return true;
    }
}