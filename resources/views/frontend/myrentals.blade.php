@extends('layouts.frontend')

@section('content')
<!-- Header -->
<section class="gradient-hero py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-glow">
      <span class="text-brand-500">Rental</span> Saya
    </h1>
    <p class="mt-3 text-white/50">Kendaraan yang sedang kamu rental</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-7xl mx-auto px-4">

    @if($bayars->isEmpty())
    <div class="text-center py-20">
      <i class="bi bi-inbox text-6xl text-white/15"></i>
      <h3 class="mt-4 text-xl font-semibold text-white/50">Belum ada rental</h3>
      <p class="mt-2 text-white/30 text-sm">Kamu belum menyewa kendaraan apapun.</p>
      <a href="{{ route('homepage') }}" class="inline-block mt-6 gradient-btn px-6 py-3 rounded-xl text-sm font-semibold shadow-lg">
        <i class="bi bi-car-front me-1"></i> Lihat Kendaraan
      </a>
    </div>
    @else
    <div class="space-y-6">
      @foreach($bayars as $bayar)
      @php
        $car = $cars->firstWhere('nama_mobil', $bayar->mobilrental);
        $driver = $drivers->firstWhere('nama_driver', $bayar->driverrental);
      @endphp
      <div class="glass-card rounded-2xl overflow-hidden animate-fade-in">
        <div class="flex flex-col md:flex-row">
          <!-- Car Image -->
          @if($car)
          <div class="md:w-72 h-48 md:h-auto flex-shrink-0 overflow-hidden">
            <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-full h-full object-cover">
          </div>
          @endif

          <!-- Details -->
          <div class="flex-1 p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
              <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/20 text-amber-400 border border-amber-500/30 mb-2">
                  <i class="bi bi-clock me-1"></i> Sedang Dirental
                </span>
                <h3 class="text-xl font-bold">{{ $bayar->mobilrental }}</h3>
                @if($car)
                <p class="text-brand-400 font-bold text-lg mt-1">
                  Rp {{ number_format($car->harga_sewa, 0, ',', '.') }} <span class="text-white/40 text-sm font-normal">/hari</span>
                </p>
                @endif
              </div>
              <div class="text-sm text-white/40">
                <i class="bi bi-calendar me-1"></i>
                {{ \Carbon\Carbon::parse($bayar->created_at)->format('d M Y, H:i') }}
              </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-4 text-sm">
              @if($car)
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-fuel-pump text-brand-400"></i> {{ $car->bahan_bakar }}
              </div>
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-people text-brand-400"></i> {{ $car->jumlah_kursi }} Kursi
              </div>
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-gear text-brand-400"></i> {{ $car->transmisi }}
              </div>
              @endif
              @if($driver)
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-person-badge text-brand-400"></i> Driver: <span class="text-white font-medium">{{ $driver->nama_driver }}</span>
              </div>
              @elseif($bayar->driverrental && $bayar->driverrental !== 'Tidak Pakai Driver')
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-person-badge text-brand-400"></i> Driver: <span class="text-white font-medium">{{ $bayar->driverrental }}</span>
              </div>
              @else
              <div class="flex items-center gap-2 text-white/60">
                <i class="bi bi-person-x text-white/30"></i> Tanpa Driver
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</section>
@endsection
