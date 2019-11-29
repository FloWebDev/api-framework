<?php

namespace App\Model;

use App\DBData\PDOS;

/**
 * CoreModel
 * 
 * Si besoin de supprimer toutes les données d'une table + remettre à zéro l'AI
 * DELETE FROM your_table;
 * UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='your_table';
 * DELETE FROM sqlite_sequence where name='your_table';
 */
abstract class CoreModel {

    /**
     * Obtenir tous les résultats associés à un Model
     * 
     * @param string $order
     * @param integer $limit
     * @param integer $offset
     */
    public function getAll($order = 'ASC', $limit = null, $offset = null) {
        $order = ($order == 'DESC') ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM " . static::TABLE_NAME . " ORDER BY id " . $order;

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
     * Permet d'obtenir une entité du Model concerné en fonction de son Id
     */ 
    public function getById($id)
    {
        $result = false;

        $sql = "SELECT * FROM " . static::TABLE_NAME ." WHERE id = :id";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->fetchObject(static::class);
        }

        return $result;
    }

    /**
     * Permet de supprimer un Model par son id
     */ 
    public function delete($id)
    {
        $result = false;

        $sql = "DELETE FROM " . static::TABLE_NAME . " WHERE id = :id";
        
        $pdoStatement = PDOS::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($pdoStatement->execute()) {
            $result = $pdoStatement->rowCount();
        }

        return $result;
    }
}