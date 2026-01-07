<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchantResource\Pages;
use App\Filament\Resources\MerchantResource\RelationManagers;
use App\Models\Merchant;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    
    protected static ?string $navigationGroup = 'إدارة المتاجر';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'تاجر';
    }

    public static function getPluralModelLabel(): string
    {
        return 'التجار';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        // معلومات المتجر
                        Forms\Components\Section::make('معلومات المتجر')
                            ->description('البيانات الأساسية للمتجر')
                            ->icon('heroicon-o-building-storefront')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('المستخدم')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('الاسم')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('البريد الإلكتروني')
                                            ->email()
                                            ->required()
                                            ->unique('users', 'email'),
                                        Forms\Components\TextInput::make('password')
                                            ->label('كلمة المرور')
                                            ->password()
                                            ->required(),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $data['role'] = 'merchant';
                                        $data['password'] = bcrypt($data['password']);
                                        return User::create($data)->id;
                                    }),
                                
                                Forms\Components\TextInput::make('store_name')
                                    ->label('اسم المتجر (إنجليزي)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                        if (!$get('slug')) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                
                                Forms\Components\TextInput::make('store_name_ar')
                                    ->label('اسم المتجر (عربي)')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط')
                                    ->required()
                                    ->unique(Merchant::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        
                        // الوصف
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
                        
                        // معلومات التواصل
                        Forms\Components\Section::make('معلومات التواصل')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('رقم الهاتف')
                                    ->tel()
                                    ->maxLength(20),
                                
                                Forms\Components\Textarea::make('address')
                                    ->label('العنوان')
                                    ->rows(2)
                                    ->maxLength(500),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                // الشريط الجانبي
                Forms\Components\Group::make()
                    ->schema([
                        // اللوجو
                        Forms\Components\Section::make('شعار المتجر')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('الشعار')
                                    ->image()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->directory('merchants/logos')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->maxSize(2048),
                            ]),
                        
                        // الحالة
                        Forms\Components\Section::make('الحالة')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('حالة المتجر')
                                    ->options([
                                        'pending' => '⏳ قيد المراجعة',
                                        'approved' => '✅ معتمد',
                                        'rejected' => '❌ مرفوض',
                                        'suspended' => '🚫 موقوف',
                                    ])
                                    ->required()
                                    ->default('pending')
                                    ->live(),
                                
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('متجر مميز')
                                    ->helperText('سيظهر في قسم المتاجر المميزة'),
                                
                                Forms\Components\DateTimePicker::make('approved_at')
                                    ->label('تاريخ الموافقة')
                                    ->visible(fn (Get $get) => $get('status') === 'approved'),
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
                Tables\Columns\ImageColumn::make('logo')
                    ->label('الشعار')
                    ->circular()
                    ->getStateUsing(function (Merchant $record): ?string {
                        if (!$record->logo) return null;
                        if (str_starts_with($record->logo, 'http')) {
                            return $record->logo;
                        }
                        return asset('storage/' . $record->logo);
                    })
                    ->defaultImageUrl(url('/images/placeholder.png')),
                
                Tables\Columns\TextColumn::make('store_name')
                    ->label('اسم المتجر')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Merchant $record): string => $record->store_name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('صاحب المتجر')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('products_count')
                    ->label('المنتجات')
                    ->counts('products')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'suspended',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                        'suspended' => 'موقوف',
                        default => $state,
                    }),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('تاريخ الموافقة')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                        'suspended' => 'موقوف',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('مميز')
                    ->placeholder('الكل')
                    ->trueLabel('مميز')
                    ->falseLabel('غير مميز'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    // زر الموافقة السريعة
                    Tables\Actions\Action::make('approve')
                        ->label('موافقة')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (Merchant $record) => $record->status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('الموافقة على المتجر')
                        ->modalDescription('هل أنت متأكد من الموافقة على هذا المتجر؟')
                        ->action(function (Merchant $record) {
                            $record->update([
                                'status' => 'approved',
                                'approved_at' => now(),
                            ]);
                            Notification::make()
                                ->title('تمت الموافقة على المتجر')
                                ->success()
                                ->send();
                        }),
                    
                    // زر الرفض السريع
                    Tables\Actions\Action::make('reject')
                        ->label('رفض')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn (Merchant $record) => $record->status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('رفض المتجر')
                        ->modalDescription('هل أنت متأكد من رفض هذا المتجر؟')
                        ->action(function (Merchant $record) {
                            $record->update(['status' => 'rejected']);
                            Notification::make()
                                ->title('تم رفض المتجر')
                                ->danger()
                                ->send();
                        }),
                    
                    // زر الإيقاف
                    Tables\Actions\Action::make('suspend')
                        ->label('إيقاف')
                        ->icon('heroicon-o-no-symbol')
                        ->color('gray')
                        ->visible(fn (Merchant $record) => $record->status === 'approved')
                        ->requiresConfirmation()
                        ->modalHeading('إيقاف المتجر')
                        ->modalDescription('هل أنت متأكد من إيقاف هذا المتجر؟')
                        ->action(function (Merchant $record) {
                            $record->update(['status' => 'suspended']);
                            Notification::make()
                                ->title('تم إيقاف المتجر')
                                ->warning()
                                ->send();
                        }),
                    
                    // زر إعادة التفعيل
                    Tables\Actions\Action::make('reactivate')
                        ->label('إعادة تفعيل')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->visible(fn (Merchant $record) => in_array($record->status, ['suspended', 'rejected']))
                        ->requiresConfirmation()
                        ->action(function (Merchant $record) {
                            $record->update([
                                'status' => 'approved',
                                'approved_at' => now(),
                            ]);
                            Notification::make()
                                ->title('تم إعادة تفعيل المتجر')
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('موافقة على المحدد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'approved',
                                        'approved_at' => now(),
                                    ]);
                                }
                            });
                            Notification::make()
                                ->title('تمت الموافقة على المتاجر المحددة')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'products']);
    }
}
