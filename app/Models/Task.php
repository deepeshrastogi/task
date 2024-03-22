<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "tasks";

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'description',
        'start_date',
        'due_date',
        'status',
        'priority',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
