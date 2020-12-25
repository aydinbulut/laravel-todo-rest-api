<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @OA\Schema(
 *      schema="Task:update",
 *      required={"name"},
 *      @OA\Property(property="name", type="string"),
 * )
 *
 * @OA\Schema(
 *      schema="Task",
 *      required={"id", "todo_id"},
 *      @OA\Property(property="id", type="integer", readOnly=true),
 *      @OA\Property(property="todo_id", type="integer"),
 *      allOf={
 *          @OA\Property(ref="#/components/schemas/Task:update"),
 *          @OA\Property(ref="#/components/schemas/Timestampable")
 *      },
 * )
 *
 * @package App\Models
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'todo_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * Get the Todo that owns the task.
     */
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
