<?php
namespace Teknasyon\app\controller;

use Teknasyon\app\model\Log;
use Teknasyon\Config\Controller;

class  LogController extends Controller{

    public function log()
    {
        $log=new Log();
        $showedLog=$log->all('logs', '*',[]);
        return $this->json($showedLog);
    }
}