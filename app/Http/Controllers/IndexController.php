<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ToDoRepositoryInterface;

class IndexController extends Controller
{
    private $repository;
    public function __construct(ToDoRepositoryInterface $repository)
    {
       $this->repository = $repository;
    }

    public function index(){
        $this->repository->WorkForUser();
        dd('ok');
    }
    public function list(){
        $data = $this->repository->getUserTodoList();
        return view('list',compact('data'));
    }
}
