@extends('layouts.frontend')

@section('content')
<!-- Header -->
<section class="gradient-hero py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-glow">
      <span class="text-brand-500">Edit</span> Profil
    </h1>
    <p class="mt-3 text-white/50">Perbarui informasi akunmu</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-2xl mx-auto px-4">
    @if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-500/20 border border-red-500/30 p-4 animate-fade-in">
      <ul class="text-red-300 text-sm space-y-1">
        @foreach ($errors->all() as $error)
        <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="glass-card rounded-2xl overflow-hidden animate-fade-in">
      <div class="bg-white/5 border-b border-white/10 px-6 py-4 text-center">
        <h3 class="font-bold text-lg"><i class="bi bi-person-gear me-2 text-brand-400"></i>Edit Profil</h3>
      </div>
      <div class="p-6 md:p-8">
        <form action="{{ route('updateprofile') }}" method="post" class="space-y-5">
          @csrf

          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Nama</label>
            <input type="text" name="name" value="{{ session('supabase_user')['name'] }}" readonly
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/50 focus:outline-none cursor-not-allowed">
          </div>

          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Email</label>
            <input type="email" name="email" value="{{ session('supabase_user')['email'] }}" required
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
          </div>

          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Password Baru</label>
            <input type="password" name="password"
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
            <p class="mt-1 text-white/30 text-xs">Kosongkan jika tidak ingin mengubah password</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
          </div>

          <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 gradient-btn py-3 rounded-xl text-sm font-semibold shadow-lg hover:shadow-brand-500/25 transition-all">
              <i class="bi bi-check-lg me-1"></i> Simpan
            </button>
            <a href="{{ route('homepage') }}" class="px-5 py-3 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">
              <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection