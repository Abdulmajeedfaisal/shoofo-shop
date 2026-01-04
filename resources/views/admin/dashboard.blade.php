<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛡️ لوحة تحكم الأدمن
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">مرحباً يا أدمن! 👋</h3>
                    <p>أنت مسجل كـ: <strong>{{ auth()->user()->role }}</strong></p>
                    <p class="mt-4 text-green-500">✅ نظام التوجيه الذكي يعمل بنجاح!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
