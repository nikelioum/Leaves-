<?php

namespace App\Filament\Resources\DayResource\Pages;

use App\Filament\Resources\DayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListDays extends ListRecords
{
    protected static string $resource = DayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
        
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make()->icon('heroicon-m-user-group'),
            'active' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'active')),
            'pending' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'pending')),
            'inactive' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'inactive')),
        ];
    }
}
