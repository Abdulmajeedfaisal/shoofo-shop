<?php

namespace App\Filament\Pages;

use App\Models\ShippingSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ShippingSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static ?string $navigationLabel = 'إعدادات الشحن';
    protected static ?string $title = 'إعدادات الشحن';
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.shipping-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'shipping_type' => ShippingSetting::get('shipping_type', 'free'),
            'fixed_shipping_cost' => ShippingSetting::get('fixed_shipping_cost', 0),
            'free_shipping_threshold' => ShippingSetting::get('free_shipping_threshold', 0),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('نوع الشحن')
                    ->description('اختر طريقة حساب تكلفة الشحن')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Forms\Components\Radio::make('shipping_type')
                            ->label('نوع الشحن')
                            ->options([
                                'free' => 'شحن مجاني - بدون رسوم شحن',
                                'fixed' => 'شحن ثابت - مبلغ ثابت لكل الطلبات',
                                'threshold' => 'شحن مجاني فوق مبلغ معين',
                                'per_merchant' => 'حسب التاجر - كل تاجر يحدد سعر الشحن',
                            ])
                            ->default('free')
                            ->required()
                            ->live()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('تكلفة الشحن الثابتة')
                    ->description('حدد تكلفة الشحن الثابتة')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\TextInput::make('fixed_shipping_cost')
                            ->label('تكلفة الشحن (ريال)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->suffix('SAR')
                            ->required(),
                    ])
                    ->visible(fn (Forms\Get $get) => in_array($get('shipping_type'), ['fixed', 'threshold'])),

                Forms\Components\Section::make('حد الشحن المجاني')
                    ->description('الطلبات فوق هذا المبلغ تحصل على شحن مجاني')
                    ->icon('heroicon-o-gift')
                    ->schema([
                        Forms\Components\TextInput::make('free_shipping_threshold')
                            ->label('الحد الأدنى للشحن المجاني (ريال)')
                            ->numeric()
                            ->minValue(0)
                            ->default(200)
                            ->suffix('SAR')
                            ->helperText('الطلبات التي تساوي أو تزيد عن هذا المبلغ ستحصل على شحن مجاني')
                            ->required(),
                    ])
                    ->visible(fn (Forms\Get $get) => $get('shipping_type') === 'threshold'),

                Forms\Components\Section::make('ملاحظة')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Placeholder::make('merchant_hint')
                            ->label('')
                            ->content('لمنح تاجر معين صلاحية تحديد أسعار الشحن الخاصة به، اذهب إلى: التجار → تعديل التاجر → فعّل "يمكنه إدارة الشحن"'),
                    ])
                    ->visible(fn (Forms\Get $get) => $get('shipping_type') !== 'per_merchant'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        ShippingSetting::set('shipping_type', $data['shipping_type']);
        ShippingSetting::set('fixed_shipping_cost', $data['fixed_shipping_cost'] ?? 0);
        ShippingSetting::set('free_shipping_threshold', $data['free_shipping_threshold'] ?? 0);

        Notification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }
}
