<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Type;

class StatsOverview extends BaseWidget
{

    //Count Users
    public function countUsers(){
        $count = User::count();
        return $count;
    }

    //Count Departments
    public function countDepartments(){
        $count = Department::count();
        return $count;
    }

    //Count Roles
    public function countRoles(){
        $count = Role::count();
        return $count;
    }

    //Count Types
    public function countTypes(){
        $count = Type::count();
        return $count;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Users', $this->countUsers()),
            Stat::make('Departments', $this->countDepartments()),
            Stat::make('User Roles', $this->countRoles()),
            Stat::make('Leave Types', $this->countTypes()),
        ];
    }
}
