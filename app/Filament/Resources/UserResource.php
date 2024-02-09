<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Password;
use Hash;
use Filament\Forms\Components\Select;
use App\Models\Role;
use App\Models\Department;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Leaves Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')->required(),
                TextInput::make('lastname')->required(),
                TextInput::make('email')->required(),
                TextInput::make('phone')->required(),
                TextInput::make('job_title')->required(),
                TextInput::make('password')
                    ->same('passwordConfirmation')
                    ->password()
                    ->maxLength(255)
                    ->required(fn($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? Hash::make($state) : '')
                    ->hiddenOn('edit')
                    ->label(strval(__('filament-authentication::filament-authentication.field.user.password'))),
                TextInput::make('passwordConfirmation')
                    ->password()
                    ->dehydrated(false)
                    ->maxLength(255)
                    ->required()
                    ->label(strval(__('filament-authentication::filament-authentication.field.user.confirm_password')))
                    ->hiddenOn('edit'),
                Select::make('role_id')
                    ->label('Select Role')
                    ->options(Role::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('department_id')
                    ->label('Select Department')
                    ->options(Department::all()->pluck('name', 'id'))
                    ->searchable(),
                FileUpload::make('personal_image')
                    ->image(),
                 Toggle::make('status'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('lastname')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('email')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('phone')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('job_title')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('role.name'),
                TextColumn::make('department.name'),
                ImageColumn::make('personal_image'),
                BooleanColumn::make('status')->searchable(),
            ])
            ->filters([
                Filter::make('status')
                ->query(fn (Builder $query): Builder => $query->where('status', true))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make(), ExportBulkAction::make()])]);
            
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
