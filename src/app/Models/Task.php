<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @OA\Schema(
 *      schema="Task",
 *      required={"id", "name", "todo_id"},
 *      @OA\Property(property="id", type="integer", readOnly=true),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="todo_id", type="integer"),
 *      allOf={@OA\Property(ref="#/components/schemas/Timestampable")},
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
     * Get the Todo that owns the task.
     */
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
