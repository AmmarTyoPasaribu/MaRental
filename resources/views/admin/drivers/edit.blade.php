@extends('layouts.admin')

@section('content')
<div class="mb-6">
  <a href="{{ route('admin.drivers.index') }}" class="text-sm text-white/40 hover:text-brand-400 transition"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar</a>
  <h1 class="text-2xl font-black mt-2"><i class="bi bi-pencil-square me-2 text-brand-400"></i>Edit Driver</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2">
    <div class="glass-card rounded-2xl border border-white/10 p-6 md:p-8">
      <form action="{{ route('admin.drivers.update', $driver->id) }}" method="post" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('put')
        <div>
          <label class="block text-sm font-medium text-white/60 mb-2">Nama Driver</label>
          <input type="text" name="nama_driver" value="{{ old('nama_driver', $driver->nama_driver) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
        </div>
        <div>
          <label class="block text-sm font-medium text-white/60 mb-2">Gender</label>
          <select name="gender" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
            <option {{ $driver->gender == 'Laki-Laki' ? 'selected' : '' }} value="Laki-Laki" class="bg-dark-800">Laki-Laki</option>
            <option {{ $driver->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan" class="bg-dark-800">Perempuan</option>
          </select>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="gradient-btn px-6 py-3 rounded-xl text-sm font-semibold shadow-lg transition-all">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.drivers.index') }}" class="px-5 py-3 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div>
    <div class="glass-card rounded-2xl border border-white/10 p-5">
      <h3 class="font-bold text-sm mb-3"><i class="bi bi-image me-1 text-brand-400"></i> Foto</h3>
      <img src="{{ $driver->gambar_sim }}" alt="{{ $driver->nama_driver }}" class="w-full rounded-xl mb-4 aspect-[4/3] object-cover">
      <form action="{{ route('admin.drivers.updateImage', $driver->id) }}" method="post" enctype="multipart/form-data" class="space-y-3">
        @csrf @method('put')
        <input type="file" name="gambar_sim" accept="image/*" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white/60 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-brand-600 file:text-white">
        <button type="submit" class="w-full gradient-btn py-2.5 rounded-xl text-sm font-semibold transition-all">
          <i class="bi bi-upload me-1"></i> Update Foto
        </button>
      </form>
    </div>
  </div>
</div>
@endsection