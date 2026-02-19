@extends('layouts.admin')

@section('content')
<div class="mb-6">
  <a href="{{ route('admin.cars.index') }}" class="text-sm text-white/40 hover:text-brand-400 transition"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar</a>
  <h1 class="text-2xl font-black mt-2"><i class="bi bi-pencil-square me-2 text-brand-400"></i>Edit Kendaraan</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Edit Form -->
  <div class="lg:col-span-2">
    <div class="glass-card rounded-2xl border border-white/10 p-6 md:p-8">
      <form action="{{ route('admin.cars.update', $car->id) }}" method="post" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('put')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Nama Mobil</label>
            <input type="text" name="nama_mobil" value="{{ old('nama_mobil', $car->nama_mobil) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Harga Sewa</label>
            <input type="number" name="harga_sewa" value="{{ old('harga_sewa', $car->harga_sewa) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Nomor Mobil</label>
            <input type="text" name="nomor_mobil" value="{{ old('nomor_mobil', $car->nomor_mobil) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Bahan Bakar</label>
            <input type="text" name="bahan_bakar" value="{{ old('bahan_bakar', $car->bahan_bakar) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Jumlah Kursi</label>
            <input type="number" name="jumlah_kursi" value="{{ old('jumlah_kursi', $car->jumlah_kursi) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Transmisi</label>
            <select name="transmisi" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
              <option {{ $car->transmisi == 'manual' ? 'selected' : '' }} value="manual" class="bg-dark-800">Manual</option>
              <option {{ $car->transmisi == 'otomatis' ? 'selected' : '' }} value="otomatis" class="bg-dark-800">Otomatis</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Status</label>
            <select name="status" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
              <option {{ $car->status == 'tersedia' ? 'selected' : '' }} value="tersedia" class="bg-dark-800">Tersedia</option>
              <option {{ $car->status == 'terbooking' ? 'selected' : '' }} value="terbooking" class="bg-dark-800">Terbooking</option>
            </select>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-white/60 mb-2">Deskripsi</label>
          <textarea name="deskripsi" rows="3" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">{{ old('deskripsi', $car->deskripsi) }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="gradient-btn px-6 py-3 rounded-xl text-sm font-semibold shadow-lg transition-all">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.cars.index') }}" class="px-5 py-3 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Image Edit -->
  <div>
    <div class="glass-card rounded-2xl border border-white/10 p-5">
      <h3 class="font-bold text-sm mb-3"><i class="bi bi-image me-1 text-brand-400"></i> Gambar</h3>
      <img src="{{ $car->gambar }}" alt="{{ $car->nama_mobil }}" class="w-full rounded-xl mb-4 aspect-[4/3] object-cover">
      <form action="{{ route('admin.cars.updateImage', $car->id) }}" method="post" enctype="multipart/form-data" class="space-y-3">
        @csrf @method('put')
        <input type="file" name="gambar" accept="image/*" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white/60 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-brand-600 file:text-white">
        <button type="submit" class="w-full gradient-btn py-2.5 rounded-xl text-sm font-semibold transition-all">
          <i class="bi bi-upload me-1"></i> Update Gambar
        </button>
      </form>
    </div>
  </div>
</div>
@endsection