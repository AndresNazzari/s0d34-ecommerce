<?php

namespace App\Repositories;

use App\Config\DbConfig;
use JetBrains\PhpStorm\ArrayShape;
use PDO;

abstract class BaseRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = DbConfig::getDBConnection();
    }


    /**
     * @param array $where
     * @param array $join
     * @return array
     */
    public function get(array $where=[], array $join=[]) : array
    {
        $params = [];
        $query = "SELECT * FROM " . $this->table();

        if (count($join) > 0) {
            $query = $this->addJoinClause($query, $join);
        }

        if (count($where) > 0) {
            $clause = $this->addWhereClause($query, $where);
            $query = $clause['query'];
            $params = $clause['params'];
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param string $query
     * @param array $join
     * [
     *  [
     *      'type' => 'INNER/LEFT/RIGHT',
     *      'table' => 'TABLE_NAME',
     *      'on' => ['left' => 'users.role_id', 'right' => 'roles.id']
     *  ]
     * ]
     * @return string
     */
    public function addJoinClause(string $query, array $join) : string
    {
        foreach ($join as $j) {
            $query .= " {$j['type']} JOIN {$j['table']} ON {$j['on']['left']} = {$j['on']['right']}";
        }
        return $query;
    }

    /**
     * @param string $query
     * @param array $where
     * @return array{params: array, query: string}
     */
    #[ArrayShape(['params' => "array", 'query' => "string"])]
    public function addWhereClause(string $query, array $where) : array
    {
        $query .= " WHERE 1=1 ";
        $params = [];

        foreach ($where as $w) {
            $paramName = str_replace('.', '_', $w['column']); // Reemplaza '.' con '_' para evitar errores en la consulta
            $query .= "AND {$w['column']} {$w['operator']} :{$paramName} ";
            $params[":{$paramName}"] = $w['value'];
        }

        return ['params' => $params, 'query' => $query];
    }

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data) : int
    {
        $query = $this->createQuery($data);
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepareExecute($data);
        var_dump($data);
        var_dump($query);

        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data) : void
    {
        $query = $this->updateQuery($data);
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepareExecute($data, $id);

        $stmt->execute($data);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void
    {
        $query = "DELETE FROM " . $this->table() . " where id = :id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);

    }

    /**
     * @param array $data
     * @return string
     */
    protected function createQuery(array $data) : string
    {
        $table = $this->table();
        $params = [];
        $query = "INSERT INTO $table ";

        $query .= '(' . implode(', ', $this->columns()) . ') ';
        $query .= 'VALUES ';
        $query .= '(:' . str_replace(', ', ', :', implode(', ', $this->columns())) . ')';

        return $query;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function updateQuery(array $data) : string
    {
        $table = $this->table();
        $params = [];
        $query = "UPDATE $table SET ";
        foreach($data as $key => $value){
            if (in_array($key, $this->columns(), true)) {
                $params[] = "$key = :$key";
            }
        }
        $query .= implode(', ', $params);
        $query .= " WHERE id = :id";
        return $query;
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return array
     */
    protected function prepareExecute(array $data, ?int $id=null) : array
    {
        $response = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns(), true)) {
                $response[":$key"] = $value;
            }
        }

        if ($id !== null) {
            $response = array_merge($response, ['id' => $id]);
        }

        return $response;
    }

    /**
     * @return string
     */
    abstract protected function table() : string;

    /**
     * @return array
     */
    abstract protected function columns() : array;
}