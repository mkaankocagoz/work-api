<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    protected $fillable = ['name', 'level', 'estimated_duration', 'provider_type', 'pending'];
}
