<?php

namespace App\Filament\Merchant\Pages;

use App\Models\Merchant;
use App\Models\ShippingSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationGroup = 'المتجر';
    
    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.merchant.pages.store-settings';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('إعدادات المتجر');
    }

    public function getTitle(): string
    {
        return __('إعدادات المتجر');
    }

    public function mount(): void
    {
        $merchant = Auth::user()->merchant;
        
        $this->form->fill([
            'store_name' => $merchant->store_name,
            'store_name_ar' => $merchant->store_name_ar,
            'description' => $merchant->description,
            'description_ar' => $merchant->description_ar,
            'logo' => $merchant->logo,
            'phone' => $merchant->phone,
            'address' => $merchant->address,
            'shipping_type' => $merchant->shipping_type ?? 'free',
            'shipping_cost' => $merchant->shipping_cost ?? 0,
            'free_shipping_threshold' => $merchant->free_shipping_threshold,
        ]);
    }

    public function form(Form $form): Form
    {
        $merchant = Auth::user()->merchant;
        $canOverride = ShippingSetting::canMerchantManageShipping($merchant);
        
        return $form
            ->schema([
                Forms\Components\Section::make(__('معلومات المتجر الأساسية'))
                    ->description(__('هذه المعلومات ستظهر للعملاء في صفحة متجرك'))
                    ->icon('heroicon-o-building-storefront')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label(__('شعار المتجر'))
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('merchants/logos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText(__('يفضل صورة مربعة بحجم 200x200 بكسل على الأقل'))
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('store_name')
                            ->label(__('اسم المتجر (إنجليزي)'))
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('store_name_ar')
                            ->label(__('اسم المتجر (عربي)'))
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('وصف المتجر'))
                    ->description(__('اكتب وصفاً جذاباً لمتجرك'))
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label(__('الوصف (إنجليزي)'))
                            ->rows(4)
                            ->maxLength(1000),
                        
                        Forms\Components\Textarea::make('description_ar')
                            ->label(__('الوصف (عربي)'))
                            ->rows(4)
                            ->maxLength(1000),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('معلومات التواصل'))
                    ->description(__('معلومات التواصل مع متجرك'))
                    ->icon('heroicon-o-phone')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label(__('رقم الهاتف'))
                            ->tel()
                            ->maxLength(20),
                        
                        Forms\Components\Textarea::make('address')
                            ->label(__('العنوان'))
                            ->rows(2)
                            ->maxLength(500),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('إعدادات الشحن'))
                    ->description($canOverride 
                        ? __('حدد تكلفة الشحن لمنتجاتك') 
                        : __('إعدادات الشحن يتحكم بها مدير الموقع'))
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Forms\Components\Placeholder::make('shipping_notice')
                            ->label('')
                            ->content('⚠️ إعدادات الشحن يتحكم بها مدير الموقع حالياً')
                            ->visible(!$canOverride),

                        Forms\Components\Radio::make('shipping_type')
                            ->label(__('نوع الشحن'))
                            ->options([
                                'free' => '🎁 شحن مجاني',
                                'fixed' => '💰 شحن ثابت',
                                'calculated' => '🎯 شحن مجاني فوق مبلغ معين',
                            ])
                            ->default('free')
                            ->live()
                            ->visible($canOverride)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('shipping_cost')
                            ->label(__('تكلفة الشحن (ريال)'))
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->suffix('SAR')
                            ->visible(fn (Forms\Get $get) => $canOverride && in_array($get('shipping_type'), ['fixed', 'calculated'])),

                        Forms\Components\TextInput::make('free_shipping_threshold')
                            ->label(__('الحد الأدنى للشحن المجاني (ريال)'))
                            ->numeric()
                            ->minValue(0)
                            ->suffix('SAR')
                            ->helperText(__('الطلبات فوق هذا المبلغ تحصل على شحن مجاني'))
                            ->visible(fn (Forms\Get $get) => $canOverride && $get('shipping_type') === 'calculated'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $merchant = Auth::user()->merchant;
        
        $updateData = [
            'store_name' => $data['store_name'],
            'store_name_ar' => $data['store_name_ar'],
            'description' => $data['description'],
            'description_ar' => $data['description_ar'],
            'logo' => $data['logo'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];

        // إضافة إعدادات الشحن إذا كان مسموحاً
        $canOverride = ShippingSetting::canMerchantManageShipping($merchant);
        if ($canOverride) {
            $updateData['shipping_type'] = $data['shipping_type'] ?? 'free';
            $updateData['shipping_cost'] = $data['shipping_cost'] ?? 0;
            $updateData['free_shipping_threshold'] = $data['free_shipping_threshold'] ?? null;
        }
        
        $merchant->update($updateData);

        Notification::make()
            ->title(__('تم حفظ الإعدادات بنجاح'))
            ->success()
            ->send();
    }
}
