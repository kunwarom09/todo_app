<?php
namespace App\Controller;
use App\Adapter\TodoAdapter;
use League\Plates\Engine;

class PageController
{
    use RenderTrait;
    public function __construct(
        protected Engine $templateEngine,
    ){
    }
   public function index(TodoAdapter $todoAdapter): void
   {
       $todo = $todoAdapter->all();
     echo $this->render('home',['data'=>$todo]);
   }
}