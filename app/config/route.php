<?php
namespace Teknasyon\Config;

use Teknasyon\Config\Config;
use Teknasyon\config\log\Driver\ILogDriver;
use Teknasyon\config\log\Logger;


class Route extends Logger
{

    public static function __callStatic($nameOfFunction, $arguments)
    {
        if(Self::is_router($arguments)){
            $logger = new Logger();
            $logger->log(json_encode([$nameOfFunction,$arguments]),ILogDriver::INFO);
            
            if(is_array($arguments[1]) && self::is_middleware($arguments)) {
                $middle = $arguments[1];
                foreach ($middle as $key => $value) {
                    $classname = 'Teknasyon\app\middleware\\'. $key;
                    $exp = explode('.',$value);
                    $parameters = [];
                    if(!empty($exp[1])){
                        $value = $exp[0];
                        unset($exp[0]);
                        $parameters = $exp;
                    }
                    $call =call_user_func_array([new $classname, $value], $parameters);
                    if(empty($call) || (!empty($call['type']) && $call['type'] == 'error')){ //error veya call false gelmesi lazım
                        if((!empty($call['type']) && $call['type'] == 'error')){
                            echo json_encode($call);exit;
                        }
                        echo 'Middleware takıldı.';
                        exit;
                    }
                }
                if($nameOfFunction == 'get') @self::_get($arguments[0], $arguments[2]);
                else if($nameOfFunction == 'post') @self::_post($arguments[0], $arguments[2]);
                else if($nameOfFunction == 'delete') @self::_delete($arguments[0], $arguments[2]);

            }else{
                if($nameOfFunction == 'get') @self::_get($arguments[0], $arguments[1]);
                else if($nameOfFunction == 'post') @self::_post($arguments[0], $arguments[1]);
                else if($nameOfFunction == 'delete') @self::_delete($arguments[0], $arguments[1]);
            }
        }
    }
    static function is_router($arg){
        $exp = explode("/", ltrim($_SERVER["REQUEST_URI"],'/'), 3);
        $exp2 = explode("/", ltrim($arg[0],'/'), 3);
        foreach ($exp2 as $key => $value) {
            if(empty($exp[$key])){
                return false;
            }
            if($exp[$key] !== $value && !preg_match('/\{(.*?)\}/', $value)){
                return false;
            }
        }
        return true;
    }

    static function is_middleware($arg_0){
      return count($arg_0) > 2 ? true:false;
    }

    static function parse_url()
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $dirname = $dirname != '/' ? $dirname : null;
        $basename = basename($_SERVER['SCRIPT_NAME']);
        $request_uri = str_replace([$dirname, $basename], [null,null], $_SERVER['REQUEST_URI']);
        return self::parse_args($request_uri);
    }

    static function parse_args($request_uri)
    {
        $_args = NULL;

        if(isset($request_uri) && !empty($request_uri)){
            if(strstr($request_uri, "?")){
                $explode_request_uri = explode("?", $request_uri);
                $request_uri = $explode_request_uri[0];

                $args = explode("&", $explode_request_uri[1]);
                for ($i=0; $i < count($args); $i++) {
                    $expArgs = explode("=", $args[$i]);
                    if(isset($expArgs[0]) && isset($expArgs[1])){
                        $_args[$expArgs[0]] = $expArgs[1];
                    }
                }
            }
        }
        return [
            "url" => $request_uri,
            "args" => $_args
        ];
    }

    static function _get($url, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
            return self::run($url, $callback);
    }

    static function _post($url, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            return self::run($url, $callback);
    }

    static function _delete($url, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
            return self::run($url, $callback);
    }

    static function run($url, $callback)
    {
        $patterns = [
            '{url}' => '([0-9a-zA-Z-_]+)',
            '{id}' => '([0-9]+)'
        ];

        $url = str_replace(array_keys($patterns), array_values($patterns), $url);

        $request_uri = self::parse_url();
        if (preg_match('@^' . $url . '$@', $request_uri['url'], $parameters)) {
            unset($parameters[0]);

            if($request_uri['args'] !== NULL) $parameters = array_merge($parameters, $request_uri['args']);

            if (is_callable($callback)) {
                call_user_func_array($callback, $parameters);
            }else{
               
                $controller = explode('@', $callback);
                $classname = 'Teknasyon\app\controller\\' . $controller[0];
                call_user_func_array([new $classname, $controller[1]], $parameters);
            
            
            
            }
            exit;

        }

    }

    /** TODO: Router group */

}
