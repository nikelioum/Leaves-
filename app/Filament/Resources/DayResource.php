<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DayResource\Pages;
use App\Filament\Resources\DayResource\RelationManagers;
use App\Models\Day;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use App\Models\User;
use App\Models\Type;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DayResource extends Resource
{
    protected static ?string $model = Day::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Users Leaves';

    protected static ?string $navigationLabel = 'Entitled Days';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Select::make('user_id')
                    ->label('Select User')
                    ->options(User::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('type_id')
                    ->label('Select Leave Type')
                    ->options(Type::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                DatePicker::make('start_date')->required(),
                DatePicker::make('end_date')->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('user.lastname')
                    ->label('Lastname')
                    ->searchable()
                    ->searchable(),
                TextColumn::make('type.name')->searchable(),
                TextColumn::make('start_date')->searchable(),
                TextColumn::make('end_date')->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(
                        fn(string $state): string => match ($state) {
                            'pending' => 'gray',
                            'inactive' => 'danger',
                            'active' => 'success',
                        },
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDays::route('/'),
            'create' => Pages\CreateDay::route('/create'),
            'edit' => Pages\EditDay::route('/{record}/edit'),
        ];
    }
}
