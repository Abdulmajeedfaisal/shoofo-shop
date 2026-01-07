<?php

namespace App\Filament\Merchant\Pages;

use App\Models\Merchant;
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
        ]);
    }

    public function form(Form $form): Form
    {
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
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $merchant = Auth::user()->merchant;
        
        $merchant->update([
            'store_name' => $data['store_name'],
            'store_name_ar' => $data['store_name_ar'],
            'description' => $data['description'],
            'description_ar' => $data['description_ar'],
            'logo' => $data['logo'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);

        Notification::make()
            ->title(__('تم حفظ الإعدادات بنجاح'))
            ->success()
            ->send();
    }
}
