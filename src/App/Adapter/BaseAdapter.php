<?php

namespace App\Adapter;

use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\ResultSet\ResultSet;

trait BaseAdapter
{
    protected string $primaryKey = 'id';
    protected function executeSql(PreparableSqlInterface $query)
    {
        $statement = $this->sql->prepareStatementForSqlObject($query);
        return $statement->execute();
    }

    public function toArray(ResultInterface  $results): array
    {
        $items = [];
        foreach ($results as $result) {
            $items[] = $result;
        }
        return $items;
    }

    public function all(string $order = 'DESC', ?int $limit = null)
    {
        $select = $this->sql->select();
        if($limit) $select->limit($limit);
        $select->order($this->primaryKey . ' ' . $order);
        return $this->executeSql($select);
    }

    public function getLatest()
    {
        return $this->all('DESC', 1)->current() ?: null;
    }

    public function delete(int $id)
    {
        $delete = $this->sql->delete();
        $delete->where([$this->primaryKey => $id]);
        return $this->executeSql($delete);
    }

    public function getById(int $id)
    {
        $select = $this->sql->select()
            ->where([$this->primaryKey => $id]);
        return $this->executeSql($select)->current();
    }
}