@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<section class="gradient-hero relative overflow-hidden py-20 md:py-28">
  <div class="absolute inset-0">
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-600/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600/15 rounded-full blur-3xl"></div>
  </div>
  <div class="relative max-w-7xl mx-auto px-4 text-center">
    <h1 class="text-5xl md:text-7xl font-black tracking-tight text-glow animate-fade-in">
      <span class="text-brand-500">MaR</span>ental
    </h1>
    <p class="mt-4 text-lg md:text-xl text-white/50 font-light max-w-xl mx-auto">
      Rental Kendaraan dengan Berbagai Keunikan
    </p>

    <!-- Search -->
    <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center max-w-2xl mx-auto">
      <form action="{{ route('homepage') }}" class="flex gap-2 flex-1">
        <input type="text" name="search" placeholder="🔍 Cari kendaraan..." value="{{ request('search') }}"
          class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 transition-all">
        <button type="submit" class="gradient-btn px-5 py-3 rounded-xl text-sm font-semibold text-white shadow-lg hover:shadow-brand-500/25 transition-all">
          Cari
        </button>
      </form>
      <form action="{{ route('homepage') }}" class="flex gap-2">
        <select name="searcha" class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
          <option value="" disabled selected class="bg-dark-800">Filter Status</option>
          <option value="tersedia" class="bg-dark-800">✅ Tersedia</option>
          <option value="terbooking" class="bg-dark-800">⏳ Terbooking</option>
        </select>
        <button type="submit" class="gradient-btn px-5 py-3 rounded-xl text-sm font-semibold text-white shadow-lg transition-all">
          Filter
        </button>
      </form>
    </div>
  </div>
</section>

<!-- Daftar Kendaraan -->
<section class="py-16">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold">🚗 Daftar <span class="text-brand-400">Kendaraan</span></h2>
      <p class="mt-2 text-white/40 text-sm">Pilih kendaraan unik untuk petualanganmu</p>
    </div>

    @if($cars->isEmpty())
    <div class="text-center py-12">
      <i class="bi bi-car-front text-5xl text-white/20"></i>
      <p class="mt-3 text-white/40">Tidak ada kendaraan ditemukan</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @foreach($cars as $car)
      <div class="glass-card rounded-2xl overflow-hidden card-hover animate-fade-in relative group">
        <!-- Status Badge -->
        <span class="absolute top-3 right-3 z-10 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg
          {{ $car->status == 'tersedia' ? 'bg-green-500/90 text-white' : 'bg-amber-500/90 text-black' }}">
          {{ $car->status }}
        </span>

        <!-- Image -->
        <div class="overflow-hidden h-48">
          <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-full h-full object-cover img-zoom">
        </div>

        <!-- Body -->
        <div class="p-5">
          <h3 class="font-bold text-lg text-white">{{ $car->nama_mobil }}</h3>
          <p class="text-brand-400 font-bold text-xl mt-1">
            Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}
            <span class="text-white/40 text-sm font-normal">/hari</span>
          </p>

          <div class="mt-4 space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-white/50">Bahan Bakar</span>
              <span class="font-medium">{{ $car->bahan_bakar }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-white/50">Kursi</span>
              <span class="font-medium">{{ $car->jumlah_kursi }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-white/50">Transmisi</span>
              <span class="font-medium">{{ $car->transmisi }}</span>
            </div>
          </div>

          @if($car->status == 'tersedia')
          <div class="mt-5 flex gap-2">
            <a href="{{ session()->has('supabase_user') ? route('contacta', $car->slug) : route('login') }}"
              class="flex-1 gradient-btn py-2.5 rounded-xl text-center text-sm font-semibold transition-all shadow-lg hover:shadow-brand-500/25">
              <i class="bi bi-key me-1"></i> Rental
            </a>
            <a href="{{ session()->has('supabase_user') ? route('detail', $car->slug) : route('login') }}"
              class="px-4 py-2.5 rounded-xl text-sm font-medium border border-white/20 text-white/70 hover:text-white hover:bg-white/10 hover:border-white/30 transition-all">
              <i class="bi bi-eye"></i>
            </a>
          </div>
          @else
          <div class="mt-5">
            <div class="py-2.5 rounded-xl text-center text-sm font-medium bg-white/5 text-white/30 border border-white/10">
              <i class="bi bi-lock me-1"></i> Sedang Dirental
            </div>
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

<!-- Daftar Driver -->
<section class="py-16 border-t border-white/5">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold">👤 Daftar <span class="text-brand-400">Driver</span></h2>
      <p class="mt-2 text-white/40 text-sm">Driver berpengalaman siap menemani perjalananmu</p>
    </div>

    @if($drivers->isEmpty())
    <div class="text-center py-12">
      <i class="bi bi-person text-5xl text-white/20"></i>
      <p class="mt-3 text-white/40">Tidak ada driver ditemukan</p>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
      @foreach($drivers as $driver)
      <div class="glass-card rounded-2xl overflow-hidden card-hover animate-fade-in text-center relative">
        <!-- Status Badge -->
        @php $driverStatus = $driver->status ?? 'tersedia'; @endphp
        <span class="absolute top-3 right-3 z-10 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg
          {{ $driverStatus == 'tersedia' ? 'bg-green-500/90 text-white' : 'bg-amber-500/90 text-black' }}">
          {{ $driverStatus }}
        </span>

        <div class="overflow-hidden h-40">
          <img src="{{ $driver->gambar_sim }}" alt="{{ $driver->nama_driver }}" class="w-full h-full object-cover img-zoom">
        </div>
        <div class="p-4">
          <h3 class="font-bold text-white">{{ $driver->nama_driver }}</h3>
          <p class="text-white/40 text-xs mt-1">{{ $driver->gender }}</p>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection