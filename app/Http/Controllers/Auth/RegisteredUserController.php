<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // القواعد الأساسية للتحقق
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:customer,merchant'],
        ];

        // إضافة قواعد التاجر إذا كان النوع تاجر
        if ($request->role === 'merchant') {
            $rules['store_name'] = ['required', 'string', 'max:255'];
            $rules['store_name_ar'] = ['nullable', 'string', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:20'];
            $rules['store_description'] = ['nullable', 'string', 'max:1000'];
        }

        $request->validate($rules);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // إذا كان تاجر، أنشئ سجل Merchant
        if ($request->role === 'merchant') {
            Merchant::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name,
                'store_name_ar' => $request->store_name_ar,
                'slug' => Str::slug($request->store_name) . '-' . $user->id,
                'description' => $request->store_description,
                'phone' => $request->phone,
                'status' => 'pending', // في انتظار الموافقة
            ]);

            // TODO: إرسال إشعار للأدمن عن تاجر جديد
            // Notification::send(User::where('role', 'admin')->get(), new NewMerchantRegistered($user));
        }

        event(new Registered($user));

        Auth::login($user);

        // التوجيه حسب الدور بعد التسجيل
        if ($user->role === 'merchant') {
            return redirect()->route('merchant.pending');
        }

        return redirect('/');
    }
}
