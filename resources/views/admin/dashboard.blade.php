@extends('layouts.admin')

@section('content')
<!-- Page Title -->
<div class="mb-8">
  <h1 class="text-2xl font-black"><span class="text-brand-400">Dashboard</span> Overview</h1>
  <p class="text-white/40 text-sm mt-1">Ringkasan data MaRental</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="glass-card rounded-2xl p-5 border border-white/10 card-hover">
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 rounded-xl bg-blue-500/20 flex items-center justify-center">
        <i class="bi bi-car-front-fill text-blue-400 text-xl"></i>
      </div>
      <span class="text-2xl font-black text-white">{{ $cars->count() }}</span>
    </div>
    <p class="text-sm text-white/50">Total Kendaraan</p>
    <p class="text-xs text-green-400 mt-1"><i class="bi bi-check-circle me-1"></i>{{ $cars->where('status', 'tersedia')->count() }} tersedia</p>
  </div>

  <div class="glass-card rounded-2xl p-5 border border-white/10 card-hover">
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 rounded-xl bg-purple-500/20 flex items-center justify-center">
        <i class="bi bi-person-badge-fill text-purple-400 text-xl"></i>
      </div>
      <span class="text-2xl font-black text-white">{{ $drivers->count() }}</span>
    </div>
    <p class="text-sm text-white/50">Total Driver</p>
    <p class="text-xs text-green-400 mt-1"><i class="bi bi-check-circle me-1"></i>{{ $drivers->filter(fn($d) => ($d->status ?? 'tersedia') === 'tersedia')->count() }} tersedia</p>
  </div>

  <div class="glass-card rounded-2xl p-5 border border-white/10 card-hover">
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="bi bi-receipt text-amber-400 text-xl"></i>
      </div>
      <span class="text-2xl font-black text-white">{{ $bayars->count() }}</span>
    </div>
    <p class="text-sm text-white/50">Rental Aktif</p>
    <p class="text-xs text-amber-400 mt-1"><i class="bi bi-clock me-1"></i>Sedang berjalan</p>
  </div>

  <div class="glass-card rounded-2xl p-5 border border-white/10 card-hover">
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 rounded-xl bg-brand-500/20 flex items-center justify-center">
        <i class="bi bi-people-fill text-brand-400 text-xl"></i>
      </div>
      <span class="text-2xl font-black text-white">{{ $users->where('is_admin', false)->count() }}</span>
    </div>
    <p class="text-sm text-white/50">Total Users</p>
    <p class="text-xs text-white/30 mt-1">Terdaftar</p>
  </div>
</div>

<!-- Available Cars Grid -->
<div class="mb-4 flex items-center justify-between">
  <h2 class="text-lg font-bold"><i class="bi bi-car-front me-2 text-brand-400"></i>Kendaraan Tersedia</h2>
  <a href="{{ route('admin.cars.index') }}" class="text-xs text-brand-400 hover:text-brand-300 transition">Lihat Semua <i class="bi bi-arrow-right"></i></a>
</div>
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
  @foreach($cars->where('status', 'tersedia')->take(10) as $car)
  <div class="glass-card rounded-2xl overflow-hidden border border-white/10 card-hover">
    <div class="aspect-[4/3] overflow-hidden">
      <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-full h-full object-cover img-zoom">
    </div>
    <div class="p-3">
      <h3 class="text-sm font-bold truncate">{{ $car->nama_mobil }}</h3>
      <p class="text-xs text-brand-400 font-semibold">Rp {{ number_format($car->harga_sewa) }}</p>
      <div class="flex items-center gap-2 mt-2 text-[10px] text-white/40">
        <span><i class="bi bi-fuel-pump"></i> {{ $car->bahan_bakar }}</span>
        <span><i class="bi bi-gear"></i> {{ $car->transmisi }}</span>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection