<?php

  function my_autoloader($class_name){
          $parts = explode('\\', $class_name);
          $class_name = end($parts);
          $classesPath = __DIR__.'/../config/'.$class_name.'.php';
          $controllersPath = __DIR__.'/../app/controller/'.$class_name.'.php';
          $middlewaresPath = __DIR__.'/../app/middleware/'.$class_name.'.php';
          $modelsPath = __DIR__.'/../app/model/'.$class_name.'.php';
          $statusPath= __DIR__.'/../config/'.$class_name.'.php';
          $logPath = __DIR__.'/../config/log/'.$class_name.'.php';
          $logDrivePath = __DIR__.'/../config/log/Driver/'.$class_name.'.php';
          if(file_exists($classesPath)){
              require_once($classesPath);
          }else if(file_exists($controllersPath)){
              require_once($controllersPath);
          }else if(file_exists($modelsPath)){
            require_once($modelsPath);
          }else if(file_exists($middlewaresPath)){
            require_once($middlewaresPath);
          }else if(file_exists($logPath)){
            require_once($logPath);
          }else if(file_exists($logDrivePath)){
            require_once($logDrivePath);
          }
  }
  
  spl_autoload_register('my_autoloader');
 
  require_once(__DIR__.'/../config/system.php');
  require_once(__DIR__.'/../routes/routes.php');
 ?>