<?php
namespace Teknasyon\Config;

class Config {
    static $URL = 'http://localhost/';
    static $NOT_AUTH_REDIRECT = [
    ];
    static $DB_SERVER    = 'mariadb';
    static $DB_NAME      = 'proje1';
    static $DB_USERNAME  = 'root';
    static $DB_PASSWORD  = 'root';
    
    static $LOG_DRİVE  = 'database';
    static $LOG_FILE_PATH  = 'storage/logs';

    static $MAINTANENCE   = 'evet';
    static $STATUS = true;
}