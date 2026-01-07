<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'منتجات الطلب';

    protected static ?string $modelLabel = 'منتج';

    protected static ?string $pluralModelLabel = 'المنتجات';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_name')
                    ->label('اسم المنتج')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('المنتج')
                    ->description(fn ($record): string => $record->product_name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('merchant.store_name')
                    ->label('المتجر')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('SAR'),
                
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->weight('bold'),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
