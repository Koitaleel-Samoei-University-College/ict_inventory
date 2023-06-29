<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllocationResource\Pages;
use App\Filament\Resources\AllocationResource\RelationManagers;
use App\Models\Allocation;
use App\Models\Item;
use App\Models\Office;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AllocationResource extends Resource
{
    protected static ?string $model = Allocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('staff_id')
                    ->label('Staff Name')
                    ->options(Staff::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('office_id')
                    ->label('Office')
                    ->options(Office::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('item_id')
                    ->label('Item Name')
                    ->options(static::getAvailableItems()->pluck('model', 'id'))
                    ->searchable()
                    ->required(),
                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff.name'),
                Tables\Columns\TextColumn::make('office.name'),
                Tables\Columns\TextColumn::make('item.model'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListAllocations::route('/'),
            'create' => Pages\CreateAllocation::route('/create'),
            'edit' => Pages\EditAllocation::route('/{record}/edit'),
        ];
    }

    public static function getAvailableItems()
    {
        $allocatedItemIds = Allocation::pluck('item_id')->toArray();

        // Query for items that have not been allocated
        return Item::whereNotIn('id', $allocatedItemIds)->get();
    }
}
