<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationGroup = 'المبيعات';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'طلب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الطلبات';
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
                        Forms\Components\Section::make('معلومات الطلب')
                            ->icon('heroicon-o-shopping-cart')
                            ->schema([
                                Forms\Components\TextInput::make('order_number')
                                    ->label('رقم الطلب')
                                    ->disabled()
                                    ->dehydrated(false),
                                
                                Forms\Components\Select::make('user_id')
                                    ->label('العميل')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                
                                Forms\Components\Select::make('status')
                                    ->label('حالة الطلب')
                                    ->options([
                                        'pending' => '⏳ قيد الانتظار',
                                        'confirmed' => '✅ مؤكد',
                                        'processing' => '🔄 قيد التجهيز',
                                        'shipped' => '🚚 تم الشحن',
                                        'delivered' => '📦 تم التسليم',
                                        'cancelled' => '❌ ملغي',
                                    ])
                                    ->required(),
                                
                                Forms\Components\Select::make('payment_status')
                                    ->label('حالة الدفع')
                                    ->options([
                                        'pending' => '⏳ قيد الانتظار',
                                        'paid' => '✅ مدفوع',
                                        'failed' => '❌ فشل',
                                        'refunded' => '↩️ مسترد',
                                    ])
                                    ->required(),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('معلومات الشحن')
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Forms\Components\TextInput::make('shipping_name')
                                    ->label('اسم المستلم')
                                    ->required(),
                                
                                Forms\Components\TextInput::make('shipping_email')
                                    ->label('البريد الإلكتروني')
                                    ->email()
                                    ->required(),
                                
                                Forms\Components\TextInput::make('shipping_phone')
                                    ->label('رقم الهاتف')
                                    ->tel()
                                    ->required(),
                                
                                Forms\Components\TextInput::make('shipping_city')
                                    ->label('المدينة')
                                    ->required(),
                                
                                Forms\Components\TextInput::make('shipping_country')
                                    ->label('الدولة')
                                    ->required(),
                                
                                Forms\Components\TextInput::make('shipping_postal_code')
                                    ->label('الرمز البريدي'),
                                
                                Forms\Components\Textarea::make('shipping_address')
                                    ->label('العنوان')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('ملاحظات')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Forms\Components\Textarea::make('notes')
                                    ->label('ملاحظات الطلب')
                                    ->rows(3),
                            ])
                            ->collapsed(),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('المبالغ')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('المجموع الفرعي')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->disabled(),
                                
                                Forms\Components\TextInput::make('tax')
                                    ->label('الضريبة')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->disabled(),
                                
                                Forms\Components\TextInput::make('shipping')
                                    ->label('الشحن')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->disabled(),
                                
                                Forms\Components\TextInput::make('total')
                                    ->label('الإجمالي')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->disabled()
                                    ->extraAttributes(['class' => 'font-bold text-lg']),
                            ]),
                        
                        Forms\Components\Section::make('طريقة الدفع')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Forms\Components\TextInput::make('payment_method')
                                    ->label('طريقة الدفع')
                                    ->disabled(),
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
                Tables\Columns\TextColumn::make('order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('items_count')
                    ->label('المنتجات')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'primary' => 'processing',
                        'secondary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                        default => $state,
                    }),
                
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('الدفع')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'gray' => 'refunded',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع',
                        'failed' => 'فشل',
                        'refunded' => 'مسترد',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('shipping_city')
                    ->label('المدينة')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('حالة الدفع')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع',
                        'failed' => 'فشل',
                        'refunded' => 'مسترد',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('confirm')
                        ->label('تأكيد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (Order $record) => $record->status === 'pending')
                        ->requiresConfirmation()
                        ->action(function (Order $record) {
                            $record->update(['status' => 'confirmed']);
                            Notification::make()->title('تم تأكيد الطلب')->success()->send();
                        }),
                    
                    Tables\Actions\Action::make('process')
                        ->label('بدء التجهيز')
                        ->icon('heroicon-o-cog')
                        ->color('primary')
                        ->visible(fn (Order $record) => $record->status === 'confirmed')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'processing']);
                            Notification::make()->title('تم بدء تجهيز الطلب')->success()->send();
                        }),
                    
                    Tables\Actions\Action::make('ship')
                        ->label('شحن')
                        ->icon('heroicon-o-truck')
                        ->color('info')
                        ->visible(fn (Order $record) => $record->status === 'processing')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'shipped']);
                            Notification::make()->title('تم شحن الطلب')->success()->send();
                        }),
                    
                    Tables\Actions\Action::make('deliver')
                        ->label('تم التسليم')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn (Order $record) => $record->status === 'shipped')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'delivered']);
                            Notification::make()->title('تم تسليم الطلب')->success()->send();
                        }),
                    
                    Tables\Actions\Action::make('cancel')
                        ->label('إلغاء')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn (Order $record) => !in_array($record->status, ['delivered', 'cancelled']))
                        ->requiresConfirmation()
                        ->modalHeading('إلغاء الطلب')
                        ->modalDescription('هل أنت متأكد من إلغاء هذا الطلب؟')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'cancelled']);
                            Notification::make()->title('تم إلغاء الطلب')->danger()->send();
                        }),
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
        return [
            OrderResource\RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'items']);
    }
}
