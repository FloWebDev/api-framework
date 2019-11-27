<?php

namespace App\DBData;

use PDO;

/**
 * PHP Data Objects Singleton
 * @link https://www.php.net/manual/fr/book.pdo.php
 * 
 */
class PDOS {

    private $session;
    private $pdo;
    private static $_instance;

    private function __construct() {
        try {
            $this->pdo = new PDO(CFG_PDOS_SGBD . ':' . CFG_PDOS_HOST_DBNAME, CFG_PDOS_USERNAME, CFG_PDOS_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
            $this->session = uniqid();
        }
        catch(\Exception $e) {
            echo 'Impossible d\'accéder à la base de données SQLite : ' . $e->getMessage();
            exit;
        }
    }

    private function getInstancePdo() {
        return $this->pdo;
    }

    public static function getPDO() {
        if(is_null(self::$_instance)) {
            self::$_instance = new PDOS();
        }

        // var_dump(self::$_instance->session);

        return self::$_instance->getInstancePdo();
    }
}