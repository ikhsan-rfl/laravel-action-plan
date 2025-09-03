<?php

namespace App\Queries;

use App\Models\Tasks;

class ActionPlanQuery
{
    public static function getTasks(string $filter, int $categoryId = 0)
    {
        return match ($filter) {
            'today' => Tasks::baseQuery(dueDate: now()->format('Y-m-d'), categoryId: $categoryId),
            '7days' => Tasks::baseQuery(dueDateDays: 7, categoryId: $categoryId),
            'completed' => Tasks::baseQuery(completed: true, categoryId: $categoryId),
            default => Tasks::baseQuery(categoryId: $categoryId),
        };
    }
}
