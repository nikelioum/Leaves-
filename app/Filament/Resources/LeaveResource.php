<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveResource\Pages;
use App\Filament\Resources\LeaveResource\RelationManagers;
use App\Models\Leave;
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

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Users Leaves';

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
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([TextColumn::make('user.name')->searchable()->label('Name'), TextColumn::make('user.lastname')->label('Lastname')->searchable(), TextColumn::make('type.name'), TextColumn::make('start_date'), TextColumn::make('end_date')])
            ->filters([
             SelectFilter::make('type')->relationship('type', 'name'),
             SelectFilter::make('user')->relationship('user', 'lastname')])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make(), ExportBulkAction::make()],
            )]);
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
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
