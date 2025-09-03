<?php

namespace App\Livewire;

use App\Models\Tasks;
use Livewire\Component;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class Sidebar extends Component
{
    public string $filter = 'today';
    public int $category_id = 0;
    public object $tasks_info;

    /**
     * Get the categories for the task.
     *
     * @return Collection
     */
    #[Computed]
    public function categories(): Collection
    {
        return Category::withCount('tasks')->get();
    }

    #[On('filter-tasks')]
    public function setFilter(string $filter, int $category_id = 0): void
    {
        $this->filter = $filter;
        $this->category_id = $category_id;
    }

    public function mount()
    {
        $applyCategory = function ($q) {
            $q->where('category_id', $this->category_id);
        };

        // today
        $today = Tasks::when($this->category_id, $applyCategory)
            ->where('due_date', date('Y-m-d'))
            ->where('completed', false)
            ->count();

        // 7 days
        $seven_days = Tasks::when($this->category_id, $applyCategory)
            ->where('due_date', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
            ->where('completed', false)
            ->count();

        // completed
        $completed = Tasks::when($this->category_id, $applyCategory)
            ->where('completed', true)
            ->count();

        $this->tasks_info = (object) [
            'today' => $today,
            'seven_days' => $seven_days,
            'completed' => $completed,
        ];
    }

    #[On('task-changed')]
    public function refreshComponent(): void
    {
        $this->mount();
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
