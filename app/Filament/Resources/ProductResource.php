<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Merchant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationGroup = 'إدارة المتاجر';
    
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'منتج';
    }

    public static function getPluralModelLabel(): string
    {
        return 'المنتجات';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('معلومات المنتج')
                            ->icon('heroicon-o-cube')
                            ->schema([
                                Forms\Components\Select::make('merchant_id')
                                    ->label('المتجر')
                                    ->options(Merchant::approved()->pluck('store_name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->reactive(),
                                
                                Forms\Components\Select::make('merchant_category_id')
                                    ->label('الفئة')
                                    ->options(function (callable $get) {
                                        $merchantId = $get('merchant_id');
                                        if (!$merchantId) return [];
                                        return \App\Models\MerchantCategory::where('merchant_id', $merchantId)
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->required(),
                                
                                Forms\Components\TextInput::make('name')
                                    ->label('الاسم (إنجليزي)')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('name_ar')
                                    ->label('الاسم (عربي)')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط')
                                    ->required()
                                    ->unique(Product::class, 'slug', ignoreRecord: true),
                                
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->maxLength(100),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('الوصف')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->label('الوصف (إنجليزي)')
                                    ->maxLength(5000),
                                
                                Forms\Components\RichEditor::make('description_ar')
                                    ->label('الوصف (عربي)')
                                    ->maxLength(5000),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('التسعير')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('السعر')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->required(),
                                
                                Forms\Components\TextInput::make('sale_price')
                                    ->label('سعر التخفيض')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->lt('price'),
                                
                                Forms\Components\TextInput::make('quantity')
                                    ->label('الكمية')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ]),
                        
                        Forms\Components\Section::make('الإعدادات')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('نشط')
                                    ->default(true),
                                
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('مميز'),
                                
                                Forms\Components\TextInput::make('featured_order')
                                    ->label('ترتيب المميز')
                                    ->numeric()
                                    ->default(0),
                            ]),
                        
                        Forms\Components\Section::make('الإحصائيات')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Placeholder::make('views_count')
                                    ->label('المشاهدات')
                                    ->content(fn (?Product $record): string => $record ? number_format($record->views_count) : '0'),
                            ])
                            ->visible(fn (?Product $record) => $record !== null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('الصورة')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->getStateUsing(function (Product $record): ?string {
                        $image = $record->images->first();
                        if (!$image) return null;
                        if (str_starts_with($image->image, 'http')) {
                            return $image->image;
                        }
                        return asset('storage/' . $image->image);
                    }),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record): string => $record->name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('merchant.store_name')
                    ->label('المتجر')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('merchantCategory.name')
                    ->label('الفئة')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('SAR')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('التخفيض')
                    ->money('SAR')
                    ->placeholder('—')
                    ->color('danger'),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->sortable()
                    ->badge()
                    ->color(fn (Product $record): string => $record->quantity > 10 ? 'success' : ($record->quantity > 0 ? 'warning' : 'danger')),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                
                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('merchant_id')
                    ->label('المتجر')
                    ->relationship('merchant', 'store_name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('نشط')
                    ->falseLabel('غير نشط'),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('مميز')
                    ->placeholder('الكل')
                    ->trueLabel('مميز')
                    ->falseLabel('غير مميز'),
                
                Tables\Filters\Filter::make('out_of_stock')
                    ->label('نفذت الكمية')
                    ->query(fn (Builder $query): Builder => $query->where('quantity', 0)),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('toggle_active')
                        ->label(fn (Product $record) => $record->is_active ? 'إيقاف' : 'تفعيل')
                        ->icon(fn (Product $record) => $record->is_active ? 'heroicon-o-pause' : 'heroicon-o-play')
                        ->color(fn (Product $record) => $record->is_active ? 'warning' : 'success')
                        ->action(function (Product $record) {
                            $record->update(['is_active' => !$record->is_active]);
                            Notification::make()
                                ->title($record->is_active ? 'تم تفعيل المنتج' : 'تم إيقاف المنتج')
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\Action::make('toggle_featured')
                        ->label(fn (Product $record) => $record->is_featured ? 'إلغاء التمييز' : 'تمييز')
                        ->icon('heroicon-o-star')
                        ->color(fn (Product $record) => $record->is_featured ? 'gray' : 'warning')
                        ->action(function (Product $record) {
                            $record->update(['is_featured' => !$record->is_featured]);
                            Notification::make()
                                ->title($record->is_featured ? 'تم تمييز المنتج' : 'تم إلغاء تمييز المنتج')
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('activate')
                        ->label('تفعيل المحدد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),
                    
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('إيقاف المحدد')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['merchant', 'merchantCategory', 'images']);
    }
}
