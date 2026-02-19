@extends('layouts.frontend')

@section('content')
<!-- Header -->
<section class="gradient-hero py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-glow">
      <span class="text-brand-500">Detail</span> Kendaraan
    </h1>
    <p class="mt-3 text-white/50">Spesifikasi lengkap kendaraan</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-5xl mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-8 animate-fade-in">

      <!-- Image -->
      <div class="lg:w-3/5">
        <div class="glass-card rounded-2xl overflow-hidden">
          <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-full h-72 lg:h-96 object-cover">
          <div class="p-6">
            <h3 class="text-lg font-bold text-white/60 mb-2">📝 Deskripsi</h3>
            <p class="text-white/80 leading-relaxed text-sm">{{ $car->deskripsi }}</p>
          </div>
        </div>
      </div>

      <!-- Specs Sidebar -->
      <div class="lg:w-2/5">
        <div class="glass-card rounded-2xl p-6 sticky top-24">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">{{ $car->nama_mobil }}</h2>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
              {{ $car->status == 'tersedia' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
              {{ $car->status }}
            </span>
          </div>

          <div class="text-brand-400 font-bold text-2xl mb-6">
            Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}
            <span class="text-white/40 text-sm font-normal">/hari</span>
          </div>

          <div class="space-y-3">
            <div class="flex justify-between items-center py-2 border-b border-white/5">
              <span class="text-white/50 text-sm"><i class="bi bi-fuel-pump me-2"></i>Bahan Bakar</span>
              <span class="font-medium text-sm">{{ $car->bahan_bakar }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-white/5">
              <span class="text-white/50 text-sm"><i class="bi bi-people me-2"></i>Jumlah Kursi</span>
              <span class="font-medium text-sm">{{ $car->jumlah_kursi }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-white/5">
              <span class="text-white/50 text-sm"><i class="bi bi-gear me-2"></i>Transmisi</span>
              <span class="font-medium text-sm">{{ $car->transmisi }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
              <span class="text-white/50 text-sm"><i class="bi bi-hash me-2"></i>Nomor</span>
              <span class="font-medium text-sm">{{ $car->nomor_mobil }}</span>
            </div>
          </div>

          @if($car->status == 'tersedia')
          <a href="{{ route('contacta', $car->slug) }}" class="block mt-6 gradient-btn py-3 rounded-xl text-center text-sm font-bold shadow-lg hover:shadow-brand-500/25 transition-all">
            <i class="bi bi-key me-1"></i> Rental Sekarang
          </a>
          @else
          <div class="mt-6 py-3 rounded-xl text-center text-sm font-medium bg-white/5 text-white/30 border border-white/10">
            <i class="bi bi-lock me-1"></i> Sedang Dirental
          </div>
          @endif

          <a href="{{ route('homepage') }}" class="block mt-3 py-2.5 rounded-xl text-center text-sm font-medium text-white/50 hover:text-white hover:bg-white/5 transition-all">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection