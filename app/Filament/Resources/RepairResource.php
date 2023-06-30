<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepairResource\Pages;
use App\Filament\Resources\RepairResource\RelationManagers;
use App\Models\Item;
use App\Models\Repair;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepairResource extends Resource
{
    protected static ?string $model = Repair::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),

                Forms\Components\Select::make('item_id')
                    ->label('Item Name')
                    ->options(static::getAvailableItems()->pluck('model', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\RichEditor::make('remarks')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('status')
                    ->options([
                        'for_Repair' => 'For Repair',
                        'Repaired' => 'Repaired',
                        'un_Repairable' => 'Un-Repairable',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Repaired By')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('item.model')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->html(),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('remarks')->html(),

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
            'index' => Pages\ListRepairs::route('/'),
            'create' => Pages\CreateRepair::route('/create'),
            'edit' => Pages\EditRepair::route('/{record}/edit'),
        ];
    }

    public static function getAvailableItems()
    {
        $repairItemIds = Repair::pluck('item_id')->toArray();

        // Query for items that have not been in repair
        return Item::whereNotIn('id', $repairItemIds)->get();
    }
}
