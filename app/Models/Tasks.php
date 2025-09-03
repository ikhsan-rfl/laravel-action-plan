<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $guarded = [];

    public static function baseQuery($dueDate = null, int $dueDateDays = 0, int $categoryId = 0, bool $completed = false)
    {
        return self::when(
            $dueDate, // Filter today
            function ($query) use ($dueDate) {
                $query->where('due_date', '=', $dueDate);
            }
        )->when(
            $dueDateDays > 0, // Filter Due Date Days
            function ($query) use ($dueDateDays) {
                $query->whereBetween('due_date', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays($dueDateDays)->format('Y-m-d')]);
            }
        )->when(
            $categoryId !== 0, // Filter by category
            function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            }
        )->where('completed', $completed);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
