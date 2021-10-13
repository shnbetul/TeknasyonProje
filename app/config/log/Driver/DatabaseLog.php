<?php
namespace Teknasyon\config\log\Driver;

use Teknasyon\Config\Database;

class DatabaseLog implements ILogDriver
{
    protected Database $driver;

    private  $date;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    protected function setDriver($driver): void
    {
        $this->driver = $driver;
    }

    public function setUp(): void
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->date = date('d:m:Y G:i:s');
    }

    public function log(string $message, int $level): void
    {
        $this->setUp();

        $values = [
            'message' => $this->date . ' - ' . $message,
            'level' => $level
        ];

        $this->driver->insert('logs',$values);
    }

    public function tearDown(): void
    {
        # code...
    }
}