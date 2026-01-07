<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'إدارة المستخدمين';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'مستخدم';
    }

    public static function getPluralModelLabel(): string
    {
        return 'المستخدمون';
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
                        Forms\Components\Section::make('معلومات المستخدم')
                            ->description('البيانات الأساسية للمستخدم')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('الاسم')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email()
                                    ->required()
                                    ->unique(User::class, 'email', ignoreRecord: true)
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('password')
                                    ->label('كلمة المرور')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->helperText(fn (string $context): string => $context === 'edit' ? 'اتركه فارغاً للإبقاء على كلمة المرور الحالية' : ''),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('الإعدادات')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Select::make('role')
                                    ->label('الدور')
                                    ->options([
                                        'admin' => '👑 مدير',
                                        'merchant' => '🏪 تاجر',
                                        'customer' => '👤 عميل',
                                    ])
                                    ->required()
                                    ->default('customer'),
                                
                                Forms\Components\Select::make('locale')
                                    ->label('اللغة')
                                    ->options([
                                        'ar' => '🇸🇦 العربية',
                                        'en' => '🇺🇸 English',
                                    ])
                                    ->default('ar'),
                            ]),
                        
                        Forms\Components\Section::make('الإحصائيات')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Placeholder::make('orders_count')
                                    ->label('الطلبات')
                                    ->content(fn (?User $record): string => $record ? $record->orders()->count() . ' طلب' : '0 طلب'),
                                
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('تاريخ التسجيل')
                                    ->content(fn (?User $record): string => $record ? $record->created_at->format('d/m/Y H:i') : '-'),
                            ])
                            ->visible(fn (?User $record) => $record !== null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('role')
                    ->label('الدور')
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'merchant',
                        'success' => 'customer',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'admin' => 'مدير',
                        'merchant' => 'تاجر',
                        'customer' => 'عميل',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('الطلبات')
                    ->counts('orders')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('merchant.store_name')
                    ->label('المتجر')
                    ->placeholder('—')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('locale')
                    ->label('اللغة')
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'ar' => '🇸🇦',
                        'en' => '🇺🇸',
                        default => '🌐',
                    })
                    ->alignCenter()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('التحقق')
                    ->dateTime('d/m/Y')
                    ->placeholder('غير محقق')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('الدور')
                    ->options([
                        'admin' => 'مدير',
                        'merchant' => 'تاجر',
                        'customer' => 'عميل',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('make_admin')
                        ->label('ترقية لمدير')
                        ->icon('heroicon-o-shield-check')
                        ->color('danger')
                        ->visible(fn (User $record) => $record->role !== 'admin')
                        ->requiresConfirmation()
                        ->modalHeading('ترقية لمدير')
                        ->modalDescription('هل أنت متأكد من ترقية هذا المستخدم لمدير؟')
                        ->action(function (User $record) {
                            $record->update(['role' => 'admin']);
                            Notification::make()
                                ->title('تم ترقية المستخدم لمدير')
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (User $record) => $record->role !== 'admin'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['merchant', 'orders']);
    }
}
