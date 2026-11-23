<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Via Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <!-- Card Login Tunggal -->
    <div class="w-full max-w-sm bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        
        <!-- Logo VS & Brand Header -->
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center gap-2.5">
                <div class="w-9 h-9 bg-[#253C6D] text-amber-400 font-black text-xs rounded-xl flex items-center justify-center tracking-wider shadow-sm">
                    VS
                </div>
                <span class="text-xl font-black text-[#253C6D] tracking-tight">
                    Via<span class="text-[#F59E0B]">Store</span>
                </span>
            </a>
            <p class="text-xs text-slate-500 font-medium mt-2">Masukkan email dan kata sandi untuk masuk.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-3 rounded-lg border border-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#253C6D] focus:ring-1 focus:ring-[#253C6D] transition" />
                @error('email')
                    <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">
                    Kata Sandi
                </label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#253C6D] focus:ring-1 focus:ring-[#253C6D] transition" />
                @error('password')
                    <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-[#253C6D] focus:ring-[#253C6D] w-3.5 h-3.5 cursor-pointer">
                    <span class="ms-2 font-medium text-slate-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-semibold text-[#253C6D] hover:underline">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-[#253C6D] hover:bg-[#1e325c] text-white font-bold text-xs rounded-lg shadow-sm transition duration-150">
                    Masuk Akun
                </button>
            </div>
        </form>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <p class="text-xs font-medium text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-[#253C6D] hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </div>
        @endif
    </div>

</body>
</html>