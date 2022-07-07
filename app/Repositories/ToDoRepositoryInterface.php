<?php
namespace App\Repositories;
interface ToDoRepositoryInterface{
    public function getAllUserWorkHour();
    public function WorkForUser();
    public function getPendingTasks();
    public function getUserTodoList();
}