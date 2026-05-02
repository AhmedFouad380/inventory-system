@if (request()->routeIs('filament.admin.pages.dashboard'))
<div class="flex justify-center items-center gap-8 p-6 bg-white dark:bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-lg mb-8 border border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-center bg-white p-2 rounded-lg shadow-inner">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo 1" class="h-20 w-auto object-contain">
    </div>
    <div class="flex items-center justify-center bg-white p-2 rounded-lg shadow-inner">
        <img src="{{ asset('logo2.jpeg') }}" alt="Logo 2" class="h-20 w-auto object-contain">
    </div>
</div>
@endif
