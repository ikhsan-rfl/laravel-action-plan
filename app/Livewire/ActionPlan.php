<?php

namespace App\Livewire;

use App\Models\Tasks;

use Livewire\Component;

use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class ActionPlan extends Component
{

    public ?string $priority = null;
    public ?string $content = null;

    /**
     * Get the tasks that are not completed, ordered by priority.
     *
     * @return Collection
     */
    #[Computed]
    public function tasks(): Collection
    {
        $task = Tasks::where('completed', false)
        ->orderBy('priority', 'asc')
        ->get();

        $task->each(function ($task) {
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
        });

        return $task;
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
        ]);

        Tasks::create([
            'content' => $this->content,
            'priority' => $this->priority,
        ]);

        $this->reset(['content', 'priority']);
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
        // dd($task, $text);

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
    }

    public function render(): View
    {
        return view('livewire.action-plan');
    }
}
