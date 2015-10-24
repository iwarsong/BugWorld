<?php

namespace QuickBug;

use Doctrine\DBAL\DriverManager;

class Kernel 
{
    private static $_instance = null;

    private $_booted = false;

    protected $_pool = array();

    protected $_config = array();

    public function __construct($config)
    {
        $this->_config = $config;
        self::$_instance = $this;
    }

    public function boot()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function instance()
    {
        if (!self::$_instance) {
            throw new \RuntimeException('Kernel is not created.');
        }

        return self::$_instance;
    }

    public function database()
    {
        $key = '_.database';
        if (!empty($this->_pool[$key])) {
            return $this->_pool[$key];
        }

        $config = $this->_config['database'];

        return $this->_pool[$key] = DriverManager::getConnection(array(
            'dbname' => $config['name'],
            'user' => $config['user'],
            'password' => $config['password'],   
            'host' => $config['host'],
            'driver' => $config['driver'],
            'charset' => $config['charset'],
        ));
    }

    public function service($name)
    {
        $class = "QuickBug\\Service\\{$name}";
        if (!class_exists($class)) {
            throw new \RuntimeException("{$class} is not exist.");
        }
        return new $class();
    }

    public function dao($name)
    {
        $class = "QuickBug\\Dao\\{$name}";
        if (!class_exists($class)) {
            throw new \RuntimeException("{$class} is not exist.");
        }
        return new $class();
    }

    protected function pool($name)
    {
        return !empty($this->_pool[$name]) ? $this->_pool[$name] : null;
    }
    
}