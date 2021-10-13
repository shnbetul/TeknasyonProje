<?php
namespace Teknasyon\config\log;

use Teknasyon\Config\Config;
use Teknasyon\Config\Database;
use Teknasyon\config\log\Driver\DatabaseLog;
use Teknasyon\config\log\Driver\FileLog;
use Teknasyon\config\log\Driver\ILogDriver;
use Teknasyon\config\log\LogILoggable;

class Logger implements ILoggable
{
   protected ILogDriver $driver;

   public function __construct()
   {
   
      if (Config::$LOG_DRİVE == "database") {
         $this->driver = new DatabaseLog(new Database);
      } elseif (Config::$LOG_DRİVE == 'file') {
         $this->driver = new FileLog(__DIR__.'/../../'.Config::$LOG_FILE_PATH);
      }
   }

   public function log(string $message, int $level): void
   {
      $this->driver->log($message, $level);
   }
}