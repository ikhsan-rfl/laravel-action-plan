<?php

namespace App\Livewire;

use App\Models\Tasks;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class ActionPlanModal extends Component
{
    public string $userId;

    // For Edit YGY
    public string $taskId;
    public string $content;
    public string $priority;
    public string $due_date;
    public mixed $category = null;
    public string $details = '';

    #[On('open-dialog')]
    public function promptDelete(string $id): void
    {
        $this->userId = $id;
    }

    #[On('open-dialog-edit-task')]
    public function promptEdit(string $id): void
    {
        $task_data = Tasks::find($id);
        $this->taskId = $id;
        $this->priority = $task_data->priority;
        $this->content = $task_data->content;
        $this->due_date = $task_data->due_date ?? '';
        $this->category = $task_data->category->id ?? null;
        $this->details = $task_data->details ?? '';
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

    public function addCategory(string $name): void
    {
        Category::create(['name' => $name]);
        $this->dispatch('close-dialog-add-category');
    }

    public function editAll(): void
    {
        $task = Tasks::find($this->taskId);

        $task->update([
            'priority' => $this->priority,
            'content' => $this->content,
            'due_date' => $this->due_date,
            'category_id' => $this->category,
            'details' => $this->details,
        ]);

        $this->dispatch('close-dialog-edit-task');
    }
    public function delete(): void
    {
        Tasks::find($this->userId)->delete();
        $this->dispatch('close-dialog');
        $this->dispatch('task-changed');
    }

    public function render()
    {
        return view('livewire.action-plan-modal');
    }
}
