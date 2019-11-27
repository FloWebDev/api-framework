<?php

namespace App\Model;

use App\DBData\PDOS;

class RoleModel extends CoreModel {

    private $id;
    private $code;
    private $name;
    
    const TABLE_NAME = 'role';

    /**
     * Permet d'obtenir une entité du Model concerné en fonction de son Id
     */ 
    public function getByCode($code)
    {
        $result = false;

        $sql = "SELECT * FROM " . self::TABLE_NAME ." WHERE code = :code LIMIT 1";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':code', $code, \PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->fetchObject(static::class);
        }

        return $result;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}