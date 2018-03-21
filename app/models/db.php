<?php

class DB
{
    public static $instance;

    public static function get_instance()
    {

        if (!self::$instance) {
            $dbdata = \Configuration\DBConfig::getConfig();
            $host = $dbdata['host'];
            $dbname = $dbdata['dbname'];
            $admin = $dbdata['username'];
            $pass = $dbdata['password'];

            try {
                self::$instance = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $admin, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo ($e->getMessage());
            }

        }
        return self::$instance;
    }
}
