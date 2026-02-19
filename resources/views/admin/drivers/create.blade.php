@extends('layouts.admin')

@section('content')
<div class="mb-6">
  <a href="{{ route('admin.drivers.index') }}" class="text-sm text-white/40 hover:text-brand-400 transition"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar</a>
  <h1 class="text-2xl font-black mt-2"><i class="bi bi-plus-circle me-2 text-brand-400"></i>Tambah Driver</h1>
</div>

<div class="max-w-lg">
  <div class="glass-card rounded-2xl border border-white/10 p-6 md:p-8">
    <form action="{{ route('admin.drivers.store') }}" method="post" enctype="multipart/form-data" class="space-y-5">
      @csrf
      <div>
        <label class="block text-sm font-medium text-white/60 mb-2">Nama Driver</label>
        <input type="text" name="nama_driver" value="{{ old('nama_driver') }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
      </div>
      <div>
        <label class="block text-sm font-medium text-white/60 mb-2">Gender</label>
        <select name="gender" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition">
          <option value="Laki-Laki" class="bg-dark-800">Laki-Laki</option>
          <option value="Perempuan" class="bg-dark-800">Perempuan</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-white/60 mb-2">Foto / SIM</label>
        <input type="file" name="gambar_sim" accept="image/*" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/60 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-600 file:text-white hover:file:bg-brand-500 transition-all">
      </div>
      <div class="flex gap-3 pt-2">
        <button type="submit" class="gradient-btn px-6 py-3 rounded-xl text-sm font-semibold shadow-lg transition-all">
          <i class="bi bi-check-lg me-1"></i> Simpan
        </button>
        <a href="{{ route('admin.drivers.index') }}" class="px-5 py-3 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection