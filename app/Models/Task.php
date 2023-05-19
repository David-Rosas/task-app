<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = ['name', 'description', 'status_task_id', 'user_id'];
    
public function statusTask()
    {
        return $this->hasOne(StatusTask::class,'id', 'status_task_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->statusTask->name;
    }

}