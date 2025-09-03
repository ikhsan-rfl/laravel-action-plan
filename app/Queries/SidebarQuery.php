<?php

namespace App\Queries;

use App\Models\Tasks;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class SidebarQuery
{
    public static function countTodayTasks(): int
    {
        return Tasks::baseQuery(dueDate: Carbon::now()->format('Y-m-d'))->count();
    }

    public static function count7DaysTasks(): int
    {
        return Tasks::baseQuery(dueDateDays: 7)->count();
    }

    public static function countCompletedTasks(): int
    {
        return Tasks::baseQuery(completed: true)->count();
    }

    public static function getCategoryCounts(): Collection
    {
        return Category::baseQuery()->withCount(['tasks' => function ($query) {
            $query->where('completed', false);
        }])->get();
    }
}
