<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToDoList extends Model
{
    protected $fillable = ['user_id', 'to_do_id', 'hour', 'week'];

    public function to_do()
    {
        return $this->belongsTo('App\Models\ToDoList', 'to_do_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
