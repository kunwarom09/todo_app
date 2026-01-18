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
        protected Adapter $adapter){
        $this->sql = new Sql($this->adapter,$this->table);
    }
    public function store($data)
    {
        $insert = $this->sql->insert()->values([
            'title' => $data['todos'],
            'status' => $data['status'],
            'created_date'=>date('Y-m-d'),
            'due_date'=>$data['due_date'],
            'updated_date'=>date('Y-m-d'),
        ]);
        return $this->executeSql($insert);
    }
}