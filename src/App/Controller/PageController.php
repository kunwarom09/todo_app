<?php
namespace App\Controller;
use League\Plates\Engine;

class PageController
{
    use RenderTrait;
    public function __construct(
        protected Engine $templateEngine,
    ){
    }
   public function index(): void
   {
     echo $this->render('home');
   }
}