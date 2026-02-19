@extends('layouts.frontend')

@section('content')
<!-- Header -->
<section class="gradient-hero py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-glow">
      <span class="text-brand-500">Form</span> Rental
    </h1>
    <p class="mt-3 text-white/50">Lengkapi data untuk menyewa kendaraan</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-2xl mx-auto px-4">
    @if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-500/20 border border-red-500/30 p-4 animate-fade-in">
      <ul class="text-red-300 text-sm space-y-1">
        @foreach ($errors->all() as $error)
        <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="glass-card rounded-2xl overflow-hidden animate-fade-in">
      <div class="bg-white/5 border-b border-white/10 px-6 py-4 text-center">
        <h3 class="font-bold text-lg"><i class="bi bi-car-front me-2 text-brand-400"></i>Form Rental Kendaraan</h3>
      </div>
      <div class="p-6 md:p-8">
        <form id="rental-form" action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data" class="space-y-5">
          @csrf

          <!-- Username -->
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Username</label>
            <input type="text" name="namaku" value="{{ session('supabase_user')['name'] }}" readonly
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/50 focus:outline-none cursor-not-allowed">
          </div>

          <!-- Mobil -->
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Kendaraan yang dirental</label>
            <input type="text" value="{{ $car->nama_mobil ?? '' }}" name="mobilrental" readonly
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none cursor-not-allowed">
          </div>

          <!-- Driver -->
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Pilih Driver</label>
            <select name="driverrental" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition-all">
              <option value="Tidak Pakai Driver" class="bg-dark-800">Tidak Pakai Driver</option>
              @foreach($drivers as $driver)
              <option value="{{ $driver->nama_driver }}" class="bg-dark-800">{{ $driver->nama_driver }}</option>
              @endforeach
            </select>
          </div>

          <!-- Bukti -->
          <div>
            <label class="block text-sm font-medium text-white/60 mb-2">Upload Bukti (KTP + SIM + Nota Transfer)</label>
            <input type="file" name="bukti" id="bukti-input" accept="image/*"
              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/60 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-600 file:text-white hover:file:bg-brand-500 transition-all">
            <p class="mt-1 text-white/30 text-xs">Satukan dokumen KTP, SIM, dan bukti transfer dalam satu gambar</p>
          </div>

          <!-- Actions -->
          <div class="flex gap-3 pt-2">
            <button type="button" id="btn-submit" onclick="confirmRental()" class="flex-1 gradient-btn py-3 rounded-xl text-sm font-semibold shadow-lg hover:shadow-brand-500/25 transition-all">
              <i class="bi bi-send me-1"></i> Kirim Pesanan
            </button>
            <a href="{{ route('homepage') }}" class="px-5 py-3 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">
              <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  function confirmRental() {
    const bukti = document.getElementById('bukti-input');
    const mobilName = document.querySelector('input[name="mobilrental"]').value;
    const driverName = document.querySelector('select[name="driverrental"]').value;

    // Validate file
    if (!bukti.files || bukti.files.length === 0) {
      showToast('Upload bukti terlebih dahulu!', 'warning');
      return;
    }

    const driverInfo = driverName === 'Tidak Pakai Driver' ? 'tanpa driver' : 'dengan driver ' + driverName;
    showConfirm(
      '🚗 Konfirmasi Rental',
      `Kamu akan merental "${mobilName}" ${driverInfo}. Lanjutkan?`,
      function() {
        // Disable button and show loading
        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2"></div> Memproses...';
        btn.classList.add('opacity-60', 'cursor-not-allowed');
        showLoading('Mengirim pesanan...');
        document.getElementById('rental-form').submit();
      }
    );
  }
</script>
@endsection
