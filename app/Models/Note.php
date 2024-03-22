<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Note extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "notes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'note',
        'task_id'
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class,'attachment_note', 'note_id',
        'attachment_id');
    }
}
