@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-black"><i class="bi bi-receipt me-2 text-brand-400"></i>Rental Aktif</h1>
    <p class="text-white/40 text-sm mt-1">Daftar rental yang sedang berjalan</p>
  </div>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-white/10 bg-white/5">
          <th class="px-4 py-3 text-left text-white/50 font-medium">No</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Nama</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Bukti</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Kendaraan</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Driver</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-white/5">
        @forelse($bayars as $bayar)
        @php
            $car = $cars->firstWhere('nama_mobil', $bayar->mobilrental);
            $driver = $drivers->firstWhere('nama_driver', $bayar->driverrental);
        @endphp
        <tr class="hover:bg-white/5 transition-colors">
          <td class="px-4 py-3 text-white/40">{{ $loop->iteration }}</td>
          <td class="px-4 py-3 font-medium">{{ $bayar->namaku }}</td>
          <td class="px-4 py-3">
            <img src="{{ $bayar->bukti }}" alt="Bukti" class="w-20 h-14 rounded-lg object-cover cursor-pointer hover:opacity-75 transition" onclick="window.open(this.src)">
          </td>
          <td class="px-4 py-3">
            <p class="font-medium">{{ $bayar->mobilrental }}</p>
            @if($car)
            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $car->status == 'terbooking' ? 'bg-amber-500/20 text-amber-400' : 'bg-green-500/20 text-green-400' }}">
              {{ $car->status }}
            </span>
            @endif
          </td>
          <td class="px-4 py-3">
            <p>{{ $bayar->driverrental ?? 'Tanpa Driver' }}</p>
            @if($driver)
            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ ($driver->status ?? 'tersedia') == 'terbooking' ? 'bg-amber-500/20 text-amber-400' : 'bg-green-500/20 text-green-400' }}">
              {{ $driver->status ?? 'tersedia' }}
            </span>
            @endif
          </td>
          <td class="px-4 py-3">
            <form onsubmit="return confirm('Selesaikan rental ini? Kendaraan & driver akan tersedia kembali.')" action="{{ route('admin.bayars.destroy', $bayar->id) }}" method="post">
              @csrf @method('delete')
              <button class="px-4 py-2 rounded-lg text-xs font-bold bg-green-500/20 text-green-400 hover:bg-green-500/30 transition">
                <i class="bi bi-check-circle me-1"></i> Selesai
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="px-4 py-8 text-center text-white/30">Tidak ada rental aktif</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
