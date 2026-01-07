<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use App\Models\GlobalCategory;
use App\Models\Merchant;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationGroup = 'المحتوى';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'بانر';
    }

    public static function getPluralModelLabel(): string
    {
        return 'البانرات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('محتوى البانر')
                            ->description('العناوين والنصوص')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('العنوان (إنجليزي)')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('title_ar')
                                    ->label('العنوان (عربي)')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle')
                                    ->label('العنوان الفرعي (إنجليزي)')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle_ar')
                                    ->label('العنوان الفرعي (عربي)')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('الرابط عند النقر')
                            ->description('اختر إلى أين يذهب الزائر عند النقر على البانر')
                            ->icon('heroicon-o-link')
                            ->schema([
                                Forms\Components\Select::make('link_type')
                                    ->label('نوع الرابط')
                                    ->options([
                                        'none' => '🚫 بدون رابط',
                                        'home' => '🏠 الصفحة الرئيسية',
                                        'stores' => '🏬 صفحة جميع المتاجر',
                                        'category' => '📁 فئة معينة',
                                        'store' => '🏪 متجر معين',
                                        'product' => '� منتج معينج',
                                        'external' => '🔗 رابط خارجي',
                                    ])
                                    ->default('none')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        // مسح الحقول عند تغيير النوع
                                        $set('link_category_id', null);
                                        $set('link_store_id', null);
                                        $set('link_product_id', null);
                                        
                                        // تعيين الرابط تلقائياً للخيارات الثابتة
                                        match($state) {
                                            'home' => $set('link', '/'),
                                            'stores' => $set('link', '/stores'),
                                            'none' => $set('link', null),
                                            default => $set('link', null),
                                        };
                                    })
                                    ->columnSpanFull(),
                                
                                Forms\Components\Select::make('link_category_id')
                                    ->label('اختر الفئة')
                                    ->options(GlobalCategory::where('is_active', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->visible(fn (Get $get) => $get('link_type') === 'category')
                                    ->required(fn (Get $get) => $get('link_type') === 'category')
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state) {
                                            $category = GlobalCategory::find($state);
                                            if ($category) {
                                                $set('link', route('categories.show', $category->slug));
                                            }
                                        }
                                    })
                                    ->live(),
                                
                                Forms\Components\Select::make('link_store_id')
                                    ->label('اختر المتجر')
                                    ->options(Merchant::where('status', 'approved')->pluck('store_name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->visible(fn (Get $get) => $get('link_type') === 'store')
                                    ->required(fn (Get $get) => $get('link_type') === 'store')
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state) {
                                            $store = Merchant::find($state);
                                            if ($store) {
                                                $set('link', route('stores.show', $store->slug));
                                            }
                                        }
                                    })
                                    ->live(),
                                
                                Forms\Components\Select::make('link_product_id')
                                    ->label('اختر المنتج')
                                    ->options(function () {
                                        return Product::where('is_active', true)
                                            ->with('merchant')
                                            ->get()
                                            ->mapWithKeys(function ($product) {
                                                return [$product->id => $product->name . ' - ' . ($product->merchant->store_name ?? '')];
                                            });
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->visible(fn (Get $get) => $get('link_type') === 'product')
                                    ->required(fn (Get $get) => $get('link_type') === 'product')
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state) {
                                            $product = Product::with('merchant')->find($state);
                                            if ($product && $product->merchant) {
                                                $set('link', route('products.show', [$product->merchant->slug, $product->slug]));
                                            }
                                        }
                                    })
                                    ->live(),
                                
                                Forms\Components\TextInput::make('link')
                                    ->label('الرابط الخارجي')
                                    ->url()
                                    ->placeholder('https://example.com')
                                    ->visible(fn (Get $get) => $get('link_type') === 'external')
                                    ->required(fn (Get $get) => $get('link_type') === 'external')
                                    ->helperText('أدخل الرابط الكامل مع https://'),
                                
                                Forms\Components\Placeholder::make('link_preview')
                                    ->label('الرابط النهائي')
                                    ->content(fn (Get $get) => $get('link') ?: 'لم يتم تحديد رابط')
                                    ->visible(fn (Get $get) => in_array($get('link_type'), ['home', 'stores', 'category', 'store', 'product'])),
                            ])
                            ->columns(1),
                        
                        Forms\Components\Section::make('الصورة')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('صورة البانر')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('banners')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->maxSize(5120)
                                    ->required()
                                    ->helperText('يفضل صورة بأبعاد 1920x600 بكسل'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('الإعدادات')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\TextInput::make('order')
                                    ->label('الترتيب')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('الأرقام الأصغر تظهر أولاً'),
                                
                                Forms\Components\Toggle::make('is_active')
                                    ->label('نشط')
                                    ->default(true)
                                    ->helperText('البانر سيظهر في الموقع'),
                            ]),
                        
                        Forms\Components\Section::make('فترة العرض')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('تاريخ البداية')
                                    ->helperText('اتركه فارغاً للعرض فوراً'),
                                
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('تاريخ النهاية')
                                    ->helperText('اتركه فارغاً للعرض دائماً')
                                    ->afterOrEqual('start_date'),
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
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->width(120)
                    ->height(60)
                    ->getStateUsing(fn (Banner $record): ?string => $record->image_url),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Banner $record): string => $record->title_ar ?? ''),
                
                Tables\Columns\TextColumn::make('link')
                    ->label('الرابط')
                    ->limit(30)
                    ->url(fn (Banner $record): ?string => $record->link, true)
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable()
                    ->badge(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('start_date')
                    ->label('البداية')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('فوري'),
                
                Tables\Columns\TextColumn::make('end_date')
                    ->label('النهاية')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('دائم'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('نشط')
                    ->falseLabel('غير نشط'),
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
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
