<?php

namespace App\Filament\Merchant\Resources;

use App\Filament\Merchant\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\MerchantCategory;
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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationGroup = 'المنتجات';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('منتج');
    }

    public static function getPluralModelLabel(): string
    {
        return __('المنتجات');
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
                Forms\Components\Group::make()
                    ->schema([
                        // Basic Information Section
                        Forms\Components\Section::make(__('معلومات المنتج'))
                            ->description(__('المعلومات الأساسية للمنتج'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('اسم المنتج (إنجليزي)'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                        if (!$get('slug') || $get('slug') === Str::slug($get('name'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                
                                Forms\Components\TextInput::make('name_ar')
                                    ->label(__('اسم المنتج (عربي)'))
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('الرابط'))
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->helperText(__('سيتم إنشاؤه تلقائياً من الاسم')),
                                
                                Forms\Components\Select::make('merchant_category_id')
                                    ->label(__('الفئة'))
                                    ->options(function () {
                                        return MerchantCategory::where('merchant_id', static::getMerchantId())
                                            ->where('is_active', true)
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('اسم الفئة (إنجليزي)'))
                                            ->required(),
                                        Forms\Components\TextInput::make('name_ar')
                                            ->label(__('اسم الفئة (عربي)')),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $data['merchant_id'] = static::getMerchantId();
                                        $data['slug'] = Str::slug($data['name']);
                                        return MerchantCategory::create($data)->id;
                                    }),
                            ])
                            ->columns(2),
                        
                        // Description Section
                        Forms\Components\Section::make(__('الوصف'))
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->label(__('الوصف (إنجليزي)'))
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                    ])
                                    ->columnSpanFull(),
                                
                                Forms\Components\RichEditor::make('description_ar')
                                    ->label(__('الوصف (عربي)'))
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        
                        // Images Section
                        Forms\Components\Section::make(__('صور المنتج'))
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Repeater::make('images')
                                    ->relationship()
                                    ->label(__('الصور'))
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label(__('الصورة'))
                                            ->image()
                                            ->imageEditor()
                                            ->directory('products')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->maxSize(5120)
                                            ->required(),
                                        
                                        Forms\Components\Toggle::make('is_primary')
                                            ->label(__('صورة رئيسية'))
                                            ->default(false),
                                        
                                        Forms\Components\TextInput::make('order')
                                            ->label(__('الترتيب'))
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(1)
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['is_primary'] ?? false ? __('الصورة الرئيسية') : __('صورة'))
                                    ->addActionLabel(__('إضافة صورة')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                // Sidebar
                Forms\Components\Group::make()
                    ->schema([
                        // Pricing Section
                        Forms\Components\Section::make(__('التسعير'))
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label(__('السعر'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('SAR')
                                    ->minValue(0),
                                
                                Forms\Components\TextInput::make('sale_price')
                                    ->label(__('سعر التخفيض'))
                                    ->numeric()
                                    ->prefix('SAR')
                                    ->minValue(0)
                                    ->lt('price')
                                    ->helperText(__('اتركه فارغاً إذا لم يكن هناك تخفيض')),
                            ]),
                        
                        // Inventory Section
                        Forms\Components\Section::make(__('المخزون'))
                            ->icon('heroicon-o-archive-box')
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('الكمية'))
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0),
                                
                                Forms\Components\TextInput::make('sku')
                                    ->label(__('رمز المنتج (SKU)'))
                                    ->maxLength(100)
                                    ->unique(Product::class, 'sku', ignoreRecord: true),
                            ]),
                        
                        // Status Section
                        Forms\Components\Section::make(__('الحالة'))
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('نشط'))
                                    ->default(true)
                                    ->helperText(__('المنتج سيظهر في المتجر')),
                                
                                Forms\Components\Toggle::make('is_featured')
                                    ->label(__('مميز'))
                                    ->default(false)
                                    ->helperText(__('سيظهر في قسم المنتجات المميزة')),
                                
                                Forms\Components\TextInput::make('featured_order')
                                    ->label(__('ترتيب العرض'))
                                    ->numeric()
                                    ->default(0)
                                    ->visible(fn (Get $get) => $get('is_featured')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primary_image')
                    ->label(__('الصورة'))
                    ->circular()
                    ->getStateUsing(function (Product $record): ?string {
                        $image = $record->primaryImage;
                        if (!$image) return null;
                        
                        // إذا كانت URL كاملة، أرجعها مباشرة
                        if (str_starts_with($image->image, 'http')) {
                            return $image->image;
                        }
                        
                        // إذا كانت مسار محلي، أرجع URL كامل
                        return asset('storage/' . $image->image);
                    })
                    ->defaultImageUrl(url('/images/placeholder.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label(__('الاسم'))
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record): string => $record->name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('merchantCategory.name')
                    ->label(__('الفئة'))
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('price')
                    ->label(__('السعر'))
                    ->money('SAR')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('sale_price')
                    ->label(__('سعر التخفيض'))
                    ->money('SAR')
                    ->sortable()
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('المخزون'))
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('نشط'))
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('مميز'))
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('تاريخ الإنشاء'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('merchant_category_id')
                    ->label(__('الفئة'))
                    ->options(function () {
                        return MerchantCategory::where('merchant_id', static::getMerchantId())
                            ->pluck('name', 'id');
                    }),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('الحالة'))
                    ->placeholder(__('الكل'))
                    ->trueLabel(__('نشط'))
                    ->falseLabel(__('غير نشط')),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('مميز'))
                    ->placeholder(__('الكل'))
                    ->trueLabel(__('مميز'))
                    ->falseLabel(__('غير مميز')),
                
                Tables\Filters\Filter::make('out_of_stock')
                    ->label(__('نفذ من المخزون'))
                    ->query(fn (Builder $query): Builder => $query->where('quantity', 0)),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label(__('تفعيل'))
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label(__('إلغاء التفعيل'))
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading(__('لا توجد منتجات'))
            ->emptyStateDescription(__('ابدأ بإضافة منتجاتك الآن'))
            ->emptyStateIcon('heroicon-o-cube')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('إضافة منتج'))
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('merchant_id', static::getMerchantId())
            // Eager loading لحل مشكلة N+1
            ->with(['primaryImage', 'merchantCategory']);
    }
}
