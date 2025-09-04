<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Tasks;
use Livewire\Component;
use App\Models\Category;

use Illuminate\View\View;
use Livewire\Attributes\On;
use App\Queries\ActionPlanQuery;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ActionPlan extends Component
{
    protected ActionPlanQuery $actionPlanQuery;
    public int $DEFAULT_LIMIT = 3;

    public string $priority;
    public string $content;
    public string $due_date = '';
    public string $category = '';
    public string $details = '';

    public string $filter = '';
    public int $categoryId = 0;
    public int $limit = 3;

    public function boot(ActionPlanQuery $actionPlanQuery): void
    {
        $this->actionPlanQuery = $actionPlanQuery;
    }
    /**
     * Get the tasks based on the current filter, ordered by priority.
     *
     * @return LengthAwarePaginator
     */
    #[Computed]
    public function tasks(): LengthAwarePaginator
    {
        $filter = $this->filter;
        $categoryId = $this->categoryId;

        $tasks = $this->actionPlanQuery->getTasks($filter, $categoryId)
            ->orderBy('priority', 'asc')
            ->paginate($this->limit);

        $tasks->each(function ($task) {
            $task->priority = match ($task->priority) {
                '1' => 'High',
                '2' => 'Medium',
                '3' => 'Low',
                default => 'Unknown',
            };

            $task->badgeColor = match ($task->priority) {
                'High' => 'bg-red-100 text-red-700 ring-red-300',
                'Medium' => 'bg-blue-100 text-blue-700 ring-blue-300',
                'Low' => 'bg-green-100 text-green-700 ring-green-300',
                default => 'bg-gray-100 text-gray-700 ring-gray-300',
            };

            $task->due_date = Carbon::parse($task->due_date)->locale('id')->translatedFormat('d F Y');
        });

        return $tasks;
    }

    public function loadMore(): void
    {
        $this->limit += 5;
    }

    #[On('filter-tasks')]
    public function setFilter(string $filter, int $categoryId = 0): void
    {
        $this->filter = $filter;
        $this->categoryId = $categoryId;
        $this->limit = $this->DEFAULT_LIMIT;
    }

    /**
     * Get the categories for the task.
     *
     * @return Collection
     */
    #[Computed]
    public function categories(): Collection
    {
        return Category::all();
    }

    /**
     * Add a new task to the database.
     *
     * @return void
     */
    public function add()
    {
        $this->validate([
            'content' => 'required|string|max:255',
            'priority' => 'required|in:1,2,3', // 1 = High, 2 = Medium, 3 = Low
            'due_date' => 'nullable|date',
            'category' => 'nullable|integer',
            'details' => 'nullable|string',
        ]);

        if (!$this->category) {
            $this->category = 0;
        }

        if (!$this->due_date) {
            $this->due_date = Carbon::now()->format('Y-m-d');
        }

        Tasks::create([
            'content' => $this->content,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'category_id' => $this->category,
            'details' => $this->details,
        ]);

        $this->reset(['content', 'priority', 'due_date', 'category', 'details']);
        $this->dispatch('task-changed');
    }

    /**
     * Edit the content of an existing task.
     *
     * @param Tasks $task
     * @param string $text
     * @return void
     */
    public function edit(Tasks $task, string $text): void
    {
        $task->update(['content' => $text]);
    }

    /**
     * Mark a task as completed.
     *
     * @param Tasks $task
     * @return void
     */
    public function complete(Tasks $task): void
    {
        $task->update(['completed' => true]);
        $this->dispatch('task-changed');
    }

    /**
     * Delete a task from the database.
     *
     * @param Tasks $task
     * @return void
     */
    public function delete(Tasks $task): void
    {
        $task->delete();
        $this->dispatch('task-changed');
    }

    public function promptEditAll(string $id): void
    {
        $this->dispatch('open-dialog-edit-task', $id);
    }

    public function promptDelete(string $id): void
    {
        $this->dispatch('open-dialog', $id);
    }

    public function render(): View
    {
        return view('livewire.action-plan');
    }
}
