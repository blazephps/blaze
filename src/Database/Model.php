<?php

namespace BlazePHP\Blaze\Database;

use PhpParser\Error;

trait Model
{
    public $table;

    protected $stmt;
    protected \PDO $pdo;

    public function setup(string $tableName)
    {
        $this->table = $tableName;
        $this->pdo = Database::connect();
    }

    public function findAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        try {
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = $id");
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT 1");
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert(array $values)
    {
        $value = implode("' , '", array_values($values));
        $key = implode(" , ", array_keys($values));
        $query =  "INSERT INTO {$this->table} ( $key ) VALUES ( '$value' )";
        return $this->pdo->exec($query);
    }

    public function update(array $values)
    {
        foreach ($values as $key => $value) {
            $query = "UPDATE $this->table SET $key = \"$value\" {$this->query}";
            $result = $this->pdo->prepare($query);
            $result->execute();
        }
    }
}