<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    use HasFactory;

    protected $table = 'status_tasks';

    public function task()
    {
        return $this->belongsTo(Task::class, 'id', 'status_task_id');
    }

}
