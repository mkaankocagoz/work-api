<?php
namespace App\Repositories;
use App\User;
use App\Models\ToDoList;
use App\Models\UserToDoList;
class ToDoRepository implements ToDoRepositoryInterface
{

    public function WorkForUser(){
        $user_info = $this->getAllUserWorkHour();
        $tasks_info = $this->getPendingTasks();
        $users = User::orderByDesc('level')->get();
        $tasks = ToDoList::get();
        $weekly_work_hour = config('app.haftalik_calisma');

        $total_week = (int)ceil($tasks_info['tasks_level_hour'] / $user_info['user_work_weekly']);

        for($i = 0; $i<$total_week; $i++){
            $week_hour = 0;
            $tasks = ToDoList::orderByDesc('level')->where('pending', 1)->get();
            foreach($tasks as $item){
                
                for($j = 0; $j<$user_info['users_count']; $j++){
                    if($week_hour < $weekly_work_hour){
                        UserToDoList::create([
                            'user_id' => $users[$j]->id,
                            'to_do_id' => $item->id,
                            'hour' => $item->estimated_duration,
                            'week' => $i+1
                        ]);
                        ToDoList::where('id', $item->id)->update(['pending' => 0]);
                        $week_hour += $item->estimated_duration;
                    }
                }
            }
               
        }

    }

    public function getAllUserWorkHour(){
        $users_count = User::count('id');
        $users_work_hours = (int)User::sum('level');
        return [
                'users_count'=>$users_count, 
                'users_work_hours'=>$users_work_hours, 
                'user_work_weekly'=>$users_work_hours*config('app.haftalik_calisma')
            ];    
    }

    public function getPendingTasks(){
        $tasks_total_level = (int)ToDoList::where('pending', 1)->sum('level');
        $tasks_total_hour = (int)ToDoList::where('pending', 1)->sum('estimated_duration');
        return [
                'tasks_total_level' => $tasks_total_level, 
                'tasks_total_hour'=>$tasks_total_hour, 
                'tasks_level_hour'=>$tasks_total_hour*$tasks_total_level
            ];
    }

    public function getUserTodoList(){
        return UserToDoList::get();
    }
}