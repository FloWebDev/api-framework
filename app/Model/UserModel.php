<?php

namespace App\Model;

use App\DBData\PDOS;
use App\Model\RoleModel;

class UserModel extends CoreModel {

    private $id;
    private $username;
    private $password;
    private $role_id;
    private $created_at;
    private $connected_at;
    private $is_active;
    
    const TABLE_NAME = 'app_user';

    public function __construct()
    {
        // Valeur par défaut
        if(is_null($this->id)) {
            $currentDate = date('Y-m-d');
            $this->setCreatedAt($currentDate);
            $this->setIsActive(1);
        }
    }

    /**
     * Permet de créer un nouvel utilisateur
     * 
     */ 
    public function new()
    {
        $success = false;
        
        $sql = "INSERT INTO " . self::TABLE_NAME . " (username, password, role_id, created_at, is_active ) VALUES (:username, :password, :role_id, :created_at, :is_active)";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':username', $this->getUsername(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->getPassword(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':role_id', $this->getRoleId(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':created_at', $this->getCreatedAt(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':is_active', $this->getIsActive(), \PDO::PARAM_INT);

        if ($pdoStatement->execute()) {
            $success = $pdoStatement->rowCount() > 0;
            if ($success) {
                $this->id = PDOS::getPDO()->lastInsertId();
            }
        }

        return $success;
    }

    /**
     * Permet de modifier les informations utilisateur
     * 
     */ 
    public function update()
    {
        $success = false;
        
        $sql = "UPDATE " . self::TABLE_NAME . " SET username = :username, password = :password, role_id = :role_id, is_active = :is_active WHERE id = " . $this->getId();
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':username', $this->getUsername(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->getPassword(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':role_id', $this->getRoleId(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':is_active', $this->getIsActive(), \PDO::PARAM_BOOL);

        if ($pdoStatement->execute()) {
            $success = $pdoStatement->rowCount() > 0;
        }

        return $success;
    }

    /**
     * Permet d'obtenir l'objet User en fonction de son username
     */ 
    public function getByUsername($username)
    {
        $result = false;

        $sql = "SELECT * FROM " . self::TABLE_NAME ." WHERE username = :username LIMIT 1";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':username', $username, \PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->fetchObject(self::class);
        }

        return $result;
    }

    /**
     * Permet de retourner la class Role de l'utilisateur
     */
    public function getRole() {
        $instanceRole = new RoleModel();
        $role = $instanceRole->getById($this->role_id);

        return $role;
    }

    /**
     * Obtenir tous les utilisateurs classés par leur identifiant (username)
     * 
     * @param string $order
     * @param integer $limit
     * @param integer $offset
     */
    public function getAllByUsername($order = 'ASC', $limit = null, $offset = null) {
        $order = $order == 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM " . static::TABLE_NAME . " ORDER BY username " . $order;

        if(!is_null($limit)) {
            $sql .= " LIMIT " . intval($limit);
        }

        if(!is_null($offset)) {
            $sql .= " OFFSET " . intval($offset);
        }

        $pdoStatement = PDOS::getPDO()->query($sql)->fetchAll(\PDO::FETCH_CLASS, static::class);

        return $pdoStatement;
    }

    /**
     * Permet de setter la date de dernière connexion de l'utilisateur connecté
     * 
     */ 
    public function updateConnectedAt()
    {
        $success = false;

        $sql = "UPDATE " . self::TABLE_NAME ." SET connected_at = :connected_at WHERE id = " . $this->getId();
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':connected_at', $this->getConnectedAt(), \PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            $success = $pdoStatement->rowCount() > 0;
        }

        return $success;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role_id
     */ 
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * Set the value of role_id
     *
     * @return  self
     */ 
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of connected_at
     */ 
    public function getConnectedAt()
    {
        return $this->connected_at;
    }

    /**
     * Set the value of connected_at
     *
     * @return  self
     */ 
    public function setConnectedAt($connected_at)
    {
        $this->connected_at = $connected_at;

        return $this;
    }

    /**
     * Get the value of is_active
     */ 
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set the value of is_active
     *
     * @return  self
     */ 
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;

        return $this;
    }
}