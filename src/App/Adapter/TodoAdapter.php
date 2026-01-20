<?php

namespace App\Adapter;

use App\DTO\TodoDTO;
use App\Enum\TodoStatus;
use App\Hydrator\TodoHydrator;
use DateTime;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class TodoAdapter
{
    use BaseAdapter;

    protected ?Sql $sql = null;
    protected string $table = 'todo_list';

    public function __construct(
        protected Adapter $adapter
    )
    {
        $this->sql = new Sql($this->adapter, $this->table);
    }


    protected function getBaseSqlWithUser(): \Laminas\Db\Sql\Select
    {
        $select = $this->sql->select();
        $select->join('users', 'users.user_id = todo_list.user_id', type: 'left');
        return $select;
    }

    public function allWithUser(string $order = 'DESC', ?int $limit = null)
    {
        $select = $this->getBaseSqlWithUser();
        if($limit) $select->limit($limit);

        //$select->order($this->primaryKey . ' ' . $order);
        return $this->executeSql($select);
    }

    public function getByIdWithUser(int $id)
    {
        $select = $this->getBaseSqlWithUser();
        $select->where([$this->primaryKey => $id]);
        return $this->executeSql($select)->current();
    }

    public function store(array $data)
    {
        $insert = $this->sql->insert()->values([
            'title' => $data['title'],
            'status' => $data['status'],
            //'created_date' => date('Y-m-d'),
            'due_date' => $data['dueDate'],
            //'updated_date' => date('Y-m-d'),
        ]);
        return $this->executeSql($insert);
    }

    public function update(int $id, array $data)
    {
     $update = $this->sql->update()->set([
         'title' => $data['title'],
         'status' => $data['status'],
         //'updated_date' => date('Y-m-d'),
     ]);
     $update->where(['id' => $id]);
     return $this->executeSql($update);
    }

    public function delete(int $id){
        $delete = $this->sql->delete();
        $delete->where(['id' => $id]);
        return $this->executeSql($delete);
    }

    public function hydrateAll(\Iterator $nestedData): array
    {
        $collection = [];
        foreach ($nestedData as $nestedDatum){
            $collection[] = TodoHydrator::make($nestedDatum);
        }
        return $collection;
    }
}