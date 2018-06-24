<?php
/**
 * Created by IntelliJ IDEA.
 * User: hezhongli
 * Date: 18/6/23
 * Time: 下午2:58
 */

namespace app\controllers;


use app\models\TodoModel;

class TodoController extends BaseController
{
    public function index(){
        $data = TodoModel::all();
        return $this->render('todo/index',['todos' => $data]);
    }

    public function create(){

     $todo = new TodoModel();
     $todo->title = $_POST['title'];
     $todo->status = 1;
     $todo->save();

//        $link = mysqli_connect('123.56.15.74','root','123123.','demo');
//        mysqli_query($link,"insert into todo VALUE (NULL,{$_POST['title']},1)");

     if($todo->save()){
         $this->redirect('todo/index');
     }
    }

    public function remove(){
        TodoModel::byId(1);
    }

    public function edit(){

    }

}