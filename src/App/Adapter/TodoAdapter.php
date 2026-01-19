<?php

namespace App\Adapter;

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

    public function store(array $data)
    {
        $insert = $this->sql->insert()->values([
            'title' => $data['title'],
            'status' => $data['status'],
            'created_date' => date('Y-m-d'),
            'due_date' => $data['dueDate'],
            'updated_date' => date('Y-m-d'),
        ]);
        return $this->executeSql($insert);
    }

    public function update(int $id, array $data)
    {
     $update = $this->sql->update()->set([
         'title' => $data['title'],
         'status' => $data['status'],
         'updated_date' => date('Y-m-d'),
     ]);
     $update->where(['id' => $id]);
     return $this->executeSql($update);
    }

    public function delete(int $id){
        $delete = $this->sql->delete();
        $delete->where(['id' => $id]);
        return $this->executeSql($delete);
    }
}