@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-black"><i class="bi bi-person-badge me-2 text-brand-400"></i>Daftar Driver</h1>
    <p class="text-white/40 text-sm mt-1">Kelola semua driver</p>
  </div>
  <a href="{{ route('admin.drivers.create') }}" class="gradient-btn px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-brand-500/25 transition-all">
    <i class="bi bi-plus-lg me-1"></i> Tambah Driver
  </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
  @forelse($drivers as $driver)
  @php $dStatus = $driver->status ?? 'tersedia'; @endphp
  <div class="glass-card rounded-2xl border border-white/10 overflow-hidden card-hover relative">
    <span class="absolute top-3 right-3 z-10 px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $dStatus == 'tersedia' ? 'bg-green-500/90 text-white' : 'bg-amber-500/90 text-black' }}">
      {{ $dStatus }}
    </span>
    <div class="aspect-[4/3] overflow-hidden">
      <img src="{{ $driver->gambar_sim }}" alt="{{ $driver->nama_driver }}" class="w-full h-full object-cover img-zoom">
    </div>
    <div class="p-4">
      <h3 class="font-bold text-sm">{{ $driver->nama_driver }}</h3>
      <div class="flex gap-2 mt-3">
        <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="flex-1 text-center px-3 py-2 rounded-lg text-xs font-medium bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition">
          <i class="bi bi-pencil"></i> Edit
        </a>
        <form onsubmit="return confirm('Hapus driver ini?')" action="{{ route('admin.drivers.destroy', $driver->id) }}" method="post" class="flex-1">
          @csrf @method('delete')
          <button class="w-full px-3 py-2 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
            <i class="bi bi-trash"></i> Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
  @empty
  <div class="col-span-full text-center py-12 text-white/30">Belum ada data driver</div>
  @endforelse
</div>
@endsection
