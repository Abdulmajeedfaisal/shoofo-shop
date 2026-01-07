<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GlobalCategoryResource\Pages;
use App\Models\GlobalCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GlobalCategoryResource extends Resource
{
    protected static ?string $model = GlobalCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static ?string $navigationGroup = 'المحتوى';
    
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'فئة عامة';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الفئات العامة';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('معلومات الفئة')
                            ->description('البيانات الأساسية للفئة')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('الاسم (إنجليزي)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                        if (!$get('slug')) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                
                                Forms\Components\TextInput::make('name_ar')
                                    ->label('الاسم (عربي)')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط')
                                    ->required()
                                    ->unique(GlobalCategory::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('icon')
                                    ->label('الأيقونة')
                                    ->placeholder('heroicon-o-shopping-bag')
                                    ->helperText('اسم الأيقونة من Heroicons'),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('الوصف')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Textarea::make('description')
                                    ->label('الوصف (إنجليزي)')
                                    ->rows(3)
                                    ->maxLength(1000),
                                
                                Forms\Components\Textarea::make('description_ar')
                                    ->label('الوصف (عربي)')
                                    ->rows(3)
                                    ->maxLength(1000),
                            ])
                            ->columns(2),
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
                                    ->helperText('الفئة ستظهر في الموقع'),
                            ]),
                        
                        Forms\Components\Section::make('الإحصائيات')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Placeholder::make('merchant_categories_count')
                                    ->label('فئات التجار')
                                    ->content(fn (?GlobalCategory $record): string => $record ? $record->merchantCategories()->count() . ' فئة' : '0 فئة'),
                            ])
                            ->visible(fn (?GlobalCategory $record) => $record !== null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('الأيقونة')
                    ->formatStateUsing(fn (?string $state): string => $state ? '🏷️' : '📁')
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->description(fn (GlobalCategory $record): string => $record->name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('merchant_categories_count')
                    ->label('فئات التجار')
                    ->counts('merchantCategories')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable()
                    ->badge(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                
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
            'index' => Pages\ListGlobalCategories::route('/'),
            'create' => Pages\CreateGlobalCategory::route('/create'),
            'edit' => Pages\EditGlobalCategory::route('/{record}/edit'),
        ];
    }
}
