<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const TODO = 'TODO';
    public const DOING = 'DOING';
    public const DONE = 'DONE';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
