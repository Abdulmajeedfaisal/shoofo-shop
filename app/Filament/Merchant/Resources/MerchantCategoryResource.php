<?php

namespace App\Filament\Merchant\Resources;

use App\Filament\Merchant\Resources\MerchantCategoryResource\Pages;
use App\Models\MerchantCategory;
use App\Models\GlobalCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MerchantCategoryResource extends Resource
{
    protected static ?string $model = MerchantCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationGroup = 'المنتجات';
    
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('فئة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('الفئات');
    }
    
    /**
     * Get current merchant ID
     */
    protected static function getMerchantId(): ?int
    {
        return Auth::user()?->merchant?->id;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('معلومات الفئة'))
                    ->description(__('أضف فئة جديدة لتنظيم منتجاتك'))
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\Select::make('global_category_id')
                            ->label(__('الفئة العامة'))
                            ->options(GlobalCategory::active()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->helperText(__('اختر الفئة العامة التي تنتمي إليها فئتك'))
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('name')
                            ->label(__('اسم الفئة (إنجليزي)'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if (!$get('slug') || $get('slug') === Str::slug($get('name'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        
                        Forms\Components\TextInput::make('name_ar')
                            ->label(__('اسم الفئة (عربي)'))
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label(__('الرابط'))
                            ->required()
                            ->maxLength(255)
                            ->unique(MerchantCategory::class, 'slug', ignoreRecord: true)
                            ->helperText(__('سيتم إنشاؤه تلقائياً من الاسم')),
                        
                        Forms\Components\Textarea::make('description')
                            ->label(__('الوصف (إنجليزي)'))
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description_ar')
                            ->label(__('الوصف (عربي)'))
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('order')
                            ->label(__('الترتيب'))
                            ->numeric()
                            ->default(0)
                            ->helperText(__('الفئات ذات الترتيب الأقل تظهر أولاً')),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('نشطة'))
                            ->default(true)
                            ->helperText(__('الفئة ستظهر في المتجر')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('الاسم'))
                    ->searchable()
                    ->sortable()
                    ->description(fn (MerchantCategory $record): string => $record->name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('globalCategory.name')
                    ->label(__('الفئة العامة'))
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->placeholder(__('غير محدد')),
                
                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('المنتجات'))
                    ->counts('products')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('order')
                    ->label(__('الترتيب'))
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('نشطة'))
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('تاريخ الإنشاء'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('global_category_id')
                    ->label(__('الفئة العامة'))
                    ->options(GlobalCategory::active()->pluck('name', 'id')),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('الحالة'))
                    ->placeholder(__('الكل'))
                    ->trueLabel(__('نشطة'))
                    ->falseLabel(__('غير نشطة')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->emptyStateHeading(__('لا توجد فئات'))
            ->emptyStateDescription(__('أنشئ فئات لتنظيم منتجاتك'))
            ->emptyStateIcon('heroicon-o-tag')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('إضافة فئة'))
                    ->icon('heroicon-o-plus'),
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
            'index' => Pages\ListMerchantCategories::route('/'),
            'create' => Pages\CreateMerchantCategory::route('/create'),
            'edit' => Pages\EditMerchantCategory::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('merchant_id', static::getMerchantId())
            // Eager loading لحل مشكلة N+1
            ->with(['globalCategory']);
    }
}
