<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class Role extends Model {

    public function UserRoles($userId)
    {
       return $this->all('user_roles','*', [
           ['user_id', $userId, '=']
       ],null,null, 'permissions.const',
       [
           ['roles','roles.id','=','user_roles.role_id'],
           ['role_permissions','role_permissions.role_id','=','roles.id'],
           ['permissions','permissions.id','=','role_permissions.permission_id']
       ]
       );
    }
    
}