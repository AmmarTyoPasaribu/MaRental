@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-black"><i class="bi bi-car-front me-2 text-brand-400"></i>Daftar Kendaraan</h1>
    <p class="text-white/40 text-sm mt-1">Kelola semua kendaraan rental</p>
  </div>
  <a href="{{ route('admin.cars.create') }}" class="gradient-btn px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-brand-500/25 transition-all">
    <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
  </a>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-white/10 bg-white/5">
          <th class="px-4 py-3 text-left text-white/50 font-medium">No</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Kendaraan</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Harga</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Status</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-white/5">
        @forelse($cars as $car)
        <tr class="hover:bg-white/5 transition-colors">
          <td class="px-4 py-3 text-white/40">{{ $loop->iteration }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-3">
              <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-16 h-12 rounded-lg object-cover">
              <div>
                <p class="font-semibold">{{ $car->nama_mobil }}</p>
                <p class="text-xs text-white/40">{{ $car->nomor_mobil }} · {{ $car->transmisi }}</p>
              </div>
            </div>
          </td>
          <td class="px-4 py-3 font-semibold text-brand-400">Rp {{ number_format($car->harga_sewa) }}</td>
          <td class="px-4 py-3">
            <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $car->status == 'tersedia' ? 'bg-green-500/20 text-green-400' : 'bg-amber-500/20 text-amber-400' }}">
              {{ $car->status }}
            </span>
          </td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <a href="{{ route('admin.cars.edit', $car->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <form onsubmit="return confirm('Hapus kendaraan ini?')" action="{{ route('admin.cars.destroy', $car->id) }}" method="post">
                @csrf @method('delete')
                <button class="px-3 py-1.5 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-4 py-8 text-center text-white/30">Belum ada data kendaraan</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
