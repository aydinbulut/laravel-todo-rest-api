<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Todo
 *
 * @OA\Schema(
 *      schema="Todo",
 *      required={"id", "name"},
 *      @OA\Property(property="id", type="integer", readOnly=true),
 *      @OA\Property(property="name", type="string"),
 *      allOf={@OA\Property(ref="#/components/schemas/Timestampable")},
 * )
 *
 * @package App\Models
 */
class Todo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the tasks for the todo.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
