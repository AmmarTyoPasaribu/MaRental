@extends('layouts.frontend')

@section('content')
<section class="py-20 flex-1 flex items-center justify-center">
  <div class="w-full max-w-md mx-auto px-4 animate-fade-in">

    @if(session()->has('message'))
    <div class="mb-6 rounded-xl bg-red-500/20 border border-red-500/30 p-4 text-red-300 text-sm">
      <i class="bi bi-exclamation-circle me-1"></i>{{ session('message') }}
    </div>
    @endif

    <div class="glass-card rounded-2xl overflow-hidden">
      <div class="p-8 text-center border-b border-white/10">
        <h1 class="text-3xl font-black"><span class="text-brand-500">MaR</span>ental</h1>
        <p class="mt-2 text-white/40 text-sm">Masuk ke akunmu</p>
      </div>

      <div class="p-8">
        @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-500/20 border border-red-500/30 p-4">
          <ul class="text-red-300 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
          @csrf
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Email</label>
            <div class="relative">
              <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
              <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3 text-sm text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all"
                placeholder="email@example.com">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Password</label>
            <div class="relative">
              <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
              <input type="password" name="password" required
                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3 text-sm text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all"
                placeholder="••••••••">
            </div>
          </div>

          <button type="submit" class="w-full gradient-btn py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-brand-500/25 transition-all">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
          </button>
        </form>

        <p class="mt-6 text-center text-sm text-white/40">
          Belum punya akun?
          <a href="{{ route('register') }}" class="text-brand-400 hover:text-brand-300 font-medium transition-colors">Daftar</a>
        </p>
      </div>
    </div>
  </div>
</section>
@endsection