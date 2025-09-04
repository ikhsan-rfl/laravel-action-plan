<?php

namespace App\Livewire;

use Livewire\Component;
use App\Queries\SidebarQuery;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class Sidebar extends Component
{
    public string $filter = '';
    public int $categoryId = 0;
    public object $tasks_info;
    protected SidebarQuery $sidebarQuery;

    /**
     * Get the categories for the task.
     *
     * @return Collection
     */
    #[Computed]
    public function categories(): Collection
    {
        return SidebarQuery::getCategoryCounts();
    }

    #[On('filter-tasks')]
    public function setFilter(string $filter, int $categoryId = 0): void
    {
        $this->filter = $filter;
        $this->categoryId = $categoryId;
    }

    public function boot(SidebarQuery $sidebarQuery): void
    {
        $this->sidebarQuery = $sidebarQuery;
    }

    public function countTodayTasks(): int
    {
        return $this->sidebarQuery->countTodayTasks();
    }

    public function count7DaysTasks(): int
    {
        return $this->sidebarQuery->count7DaysTasks();
    }

    public function countCompletedTasks(): int
    {
        return $this->sidebarQuery->countCompletedTasks();
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
