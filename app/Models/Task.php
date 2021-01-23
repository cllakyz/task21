<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

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

    /**
     * Assigned user
     *
     * @return BelongsTo
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * sortByStatus func
     *
     * @return Collection
     */
    public static function sortByStatus(): Collection
    {
        $doingArr = [];
        $todoArr = [];
        $doneArr = [];
        $tasks = Task::all();
        foreach ($tasks as $task) {
            if ($task->status === Task::DOING) {
                $doingArr[] = $task;
            } elseif ($task->status === Task::TODO) {
                $todoArr[] = $task;
            } else {
                $doneArr[] = $task;
            }
        }

        return collect(array_merge(self::quickSort($doingArr), self::quickSort($todoArr), self::quickSort($doneArr)));
    }

    /**
     * Quick Sort function
     *
     * @param $data
     * @return array
     */
    private static function quickSort($data): array
    {
        $left = [];
        $right = [];

        if (count($data) < 2) {
            return $data;
        }

        $pivot_key = key($data);
        $pivot = array_shift($data);

        foreach ($data as $d) {
            if ($d->title <= $pivot->title) {
                $left[] = $d;
            } elseif ($d->title > $pivot->title) {
                $right[] = $d;
            }
        }
        return array_merge(self::quickSort($left), [$pivot_key => $pivot], self::quickSort($right));
    }
}
