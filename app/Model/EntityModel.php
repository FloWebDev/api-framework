<?php

namespace App\Model;

use App\DBData\PDOS;
use App\Model\CategoryModel;

class EntityModel extends CoreModel {

    private $id;
    private $content;
    private $vote;
    private $category_id;
    private $created_at;
    private $updated_at;
    
    const TABLE_NAME = 'entity';

    public function __construct()
    {
        // Valeur par défaut
        if(is_null($this->id)) {
            $currentDate = date('Y-m-d');
            $vote = mt_rand(1000, 99999);
            $this->setCreatedAt($currentDate);
            $this->setVote($vote);
        }
    }

    /**
     * Permet de créer une nouvelle entity
     */ 
    public function new()
    {
        $success = false;
        
        $sql = "INSERT INTO " . self::TABLE_NAME . " (content, vote, category_id, created_at) VALUES (:content, :vote, :category, :created_at)";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':content', $this->getContent(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':vote', $this->getVote(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':category', $this->getCategoryId(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':created_at', $this->getCreatedAt(), \PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            $success = $pdoStatement->rowCount() > 0;
            if ($success) {
                $this->id = PDOS::getPDO()->lastInsertId();
            }
        }

        return $success;
    }

    /**
     * Permet de mettre à jour une entity
     */ 
    public function update()
    {
        $success = false;

        $currentDate = date('Y-m-d');

        $sql = "UPDATE " . self::TABLE_NAME . " SET content = :content, vote = :vote, category_id = :category, updated_at = :updated_at WHERE id = " . $this->getId();
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':content', $this->getContent(), \PDO::PARAM_STR);
        $pdoStatement->bindValue(':vote', $this->getVote(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':category', $this->getCategoryId(), \PDO::PARAM_INT);
        $pdoStatement->bindValue(':updated_at', $currentDate, \PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            $success = $pdoStatement->rowCount() > 0;
        }

        return $success;
    }

    /**
     * Permet de retourner la class Category de l'entity concernée
     */
    public function getCategory() {
        $instanceCategory = new CategoryModel();
        $category = $instanceCategory->getById($this->category_id);

        return $category;
    }

    /**
     * Obtenir tous les résultats associés à un Model
     * 
     * @param integer $limit
     * @param string $category
     */
    public function getApiAll($limit = 2500, $category = null) {

        $result = false;

        $sql = "SELECT e.id, e.content, e.category_id, e.created_at, e.updated_at FROM " . self::TABLE_NAME . " AS e
            LEFT JOIN category AS c ON e.category_id = c.id";

        if(!is_null($category)) {
            $sql .= " WHERE c.name = :category ";
        }

        $sql .= " ORDER BY e.id DESC 
            LIMIT :limit;";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        if(!is_null($category)) {
            $pdoStatement->bindValue(':category', $category, \PDO::PARAM_STR);
        }
        $pdoStatement->bindValue(':limit', $limit, \PDO::PARAM_INT);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->fetchAll(\PDO::FETCH_CLASS, self::class);
        }

        return $result;
    }

    /**
     * Permet de rechercher une entity par mot clé
     * 
     * @param string $keyword
     * @param int $limit
     * @param int $offset
     * 
     * @return array
     */
    public function search(string $keyword, int $limit = 1, int $offset = 0) {
        $result = false;

        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE content LIKE '%" . $keyword . "%' COLLATE NOCASE 
        LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        
        $pdoStatement = PDOS::getPDO()->query($sql);

        if ($pdoStatement) {
            $result = $pdoStatement->fetchAll(\PDO::FETCH_CLASS, self::class);
        }

        return $result;
    }

    /**
     * ATTENTION !!!
     * Permet de purger la table des entités
     * et remettre l'auto-incrément à zéro
     * 
     */ 
    public function purge()
    {
        $result = false;

        $sql = "DELETE from " . self::TABLE_NAME . "; 
            DELETE from sqlite_sequence WHERE name='" . self::TABLE_NAME . "';";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->rowCount();
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
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of vote
     */ 
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set the value of vote
     *
     * @return  self
     */ 
    public function setVote($vote)
    {
        $this->vote = $vote;

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
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    /**
     * Get the value of category_id
     */ 
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
}