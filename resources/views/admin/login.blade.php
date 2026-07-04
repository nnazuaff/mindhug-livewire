<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - MindHug</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-stone-100 min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#a47551]/15">
                <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-10 w-10 rounded-lg">
            </span>
            <h1 class="mt-4 text-2xl font-bold text-stone-800">Admin MindHug</h1>
            <p class="text-sm text-stone-500 mt-1">Masuk untuk mengelola aplikasi</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}"
            class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
                <input name="password" type="password" required
                    class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
            </div>
            <button type="submit"
                class="w-full rounded-xl bg-[#a47551] px-4 py-3 text-sm font-semibold text-white hover:bg-[#8f6243] transition-colors">
                Masuk
            </button>
        </form>
    </div>
</body>

</html>
