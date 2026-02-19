<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="MaRental - Platform Rental Kendaraan Unik" />
  <title>MaRental - Rental Kendaraan</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-dark-900 text-white min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="glass sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight">
          <img src="{{ asset('assets/logo.png') }}" alt="MaRental" class="h-9 w-9 rounded-lg object-contain">
          <span><span class="text-brand-500">MaR</span>ental</span>
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-2">
          <a href="{{ route('homepage') }}" class="px-4 py-2 rounded-full text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">
            <i class="bi bi-house-door me-1"></i> Home
          </a>
          @if(session()->has('supabase_user'))
          <a href="{{ route('myrentals') }}" class="px-4 py-2 rounded-full text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">
            <i class="bi bi-car-front me-1"></i> Rental Saya
          </a>
          <a href="{{ route('profile') }}" class="px-4 py-2 rounded-full text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">
            <i class="bi bi-person-circle me-1"></i> {{ session('supabase_user')['name'] }}
          </a>
          <form action="{{ route('logout') }}" method="post" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-full text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
          @else
          <a href="{{ route('login') }}" class="gradient-btn px-5 py-2 rounded-full text-sm font-semibold text-white shadow-lg hover:shadow-brand-500/25 transition-all">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
          </a>
          @endif
        </div>

        <!-- Mobile menu button -->
        <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg text-white/80 hover:bg-white/10">
          <i class="bi bi-list text-xl"></i>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-1">
        <a href="{{ route('homepage') }}" class="block px-4 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10">🏠 Home</a>
        @if(session()->has('supabase_user'))
        <a href="{{ route('myrentals') }}" class="block px-4 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10">🚗 Rental Saya</a>
        <a href="{{ route('profile') }}" class="block px-4 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10">👤 {{ session('supabase_user')['name'] }}</a>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-sm text-red-400 hover:bg-red-500/10">🚪 Logout</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg text-sm text-brand-400 hover:bg-white/10">🔐 Login</a>
        @endif
      </div>
    </div>
  </nav>

  <!-- Flash Messages -->
  @if(session()->has('message'))
  <div id="flash-msg" class="max-w-7xl mx-auto px-4 mt-4 animate-fade-in">
    <div class="rounded-xl px-5 py-3 text-sm font-medium flex items-center justify-between
      {{ session()->get('alert-type') === 'success' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : '' }}
      {{ session()->get('alert-type') === 'info' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : '' }}
      {{ session()->get('alert-type') === 'danger' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : '' }}">
      <span><i class="bi bi-check-circle-fill me-2"></i>{{ session()->get('message') }}</span>
      <button onclick="this.parentElement.parentElement.remove()" class="text-white/50 hover:text-white"><i class="bi bi-x-lg"></i></button>
    </div>
  </div>
  @endif

  <!-- Content -->
  <main class="flex-1">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="glass mt-auto">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="text-center">
        <h3 class="text-xl font-black mb-2"><span class="text-brand-500">MaR</span>ental</h3>
        <p class="text-white/40 text-sm">Rental Kendaraan dengan Berbagai Keunikan</p>
        <div class="mt-4 pt-4 border-t border-white/10">
          <p class="text-white/30 text-xs">&copy; {{ date('Y') }} MaRental. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Loading Overlay -->
  <div id="loading-overlay" class="fixed inset-0 z-[9999] bg-dark-900/90 flex items-center justify-center hidden">
    <div class="text-center">
      <div class="w-12 h-12 border-4 border-brand-500/30 border-t-brand-500 rounded-full animate-spin mx-auto"></div>
      <p class="mt-4 text-white/60 text-sm font-medium" id="loading-text">Memuat...</p>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div id="confirm-modal" class="fixed inset-0 z-[9998] bg-black/70 flex items-center justify-center hidden">
    <div class="glass-card rounded-2xl p-6 max-w-sm mx-4 text-center animate-fade-in">
      <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-brand-500/20 flex items-center justify-center">
        <i class="bi bi-question-circle text-3xl text-brand-400"></i>
      </div>
      <h3 class="text-lg font-bold mb-2" id="confirm-title">Konfirmasi</h3>
      <p class="text-white/50 text-sm mb-6" id="confirm-message">Apakah kamu yakin?</p>
      <div class="flex gap-3">
        <button onclick="confirmModalCancel()" class="flex-1 py-2.5 rounded-xl text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:bg-white/10 transition-all">
          Batal
        </button>
        <button onclick="confirmModalOk()" class="flex-1 gradient-btn py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all">
          Ya, Lanjut
        </button>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toast-container" class="fixed top-20 right-4 z-[9997] space-y-3"></div>

  <script>
    // ─── Loading Overlay ───
    function showLoading(text) {
      const overlay = document.getElementById('loading-overlay');
      const loadingText = document.getElementById('loading-text');
      loadingText.textContent = text || 'Memuat...';
      overlay.classList.remove('hidden');
    }
    function hideLoading() {
      document.getElementById('loading-overlay').classList.add('hidden');
    }

    // Show loading on all internal links
    document.addEventListener('click', function(e) {
      const link = e.target.closest('a[href]');
      if (link && link.href && link.href.startsWith(window.location.origin) && !link.hasAttribute('download') && !link.target) {
        showLoading('Memuat halaman...');
      }
    });

    // Hide loading when page fully loaded (for back/forward navigation)
    window.addEventListener('pageshow', function() { hideLoading(); });

    // ─── Toast System ───
    function showToast(message, type = 'info', duration = 3000) {
      const container = document.getElementById('toast-container');
      const toast = document.createElement('div');
      const colors = {
        success: 'bg-green-500/20 text-green-300 border-green-500/30',
        danger: 'bg-red-500/20 text-red-300 border-red-500/30',
        info: 'bg-blue-500/20 text-blue-300 border-blue-500/30',
        warning: 'bg-amber-500/20 text-amber-300 border-amber-500/30',
      };
      const icons = { success: 'bi-check-circle-fill', danger: 'bi-x-circle-fill', info: 'bi-info-circle-fill', warning: 'bi-exclamation-triangle-fill' };
      toast.className = `rounded-xl px-5 py-3 text-sm font-medium border ${colors[type] || colors.info} shadow-2xl animate-fade-in flex items-center gap-2 min-w-[280px]`;
      toast.innerHTML = `<i class="bi ${icons[type] || icons.info}"></i> ${message}`;
      container.appendChild(toast);
      setTimeout(() => {
        toast.style.transition = 'all 0.4s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 400);
      }, duration);
    }

    // ─── Confirmation Modal ───
    let confirmCallback = null;
    function showConfirm(title, message, callback) {
      document.getElementById('confirm-title').textContent = title;
      document.getElementById('confirm-message').textContent = message;
      document.getElementById('confirm-modal').classList.remove('hidden');
      confirmCallback = callback;
    }
    function confirmModalOk() {
      document.getElementById('confirm-modal').classList.add('hidden');
      if (confirmCallback) confirmCallback();
    }
    function confirmModalCancel() {
      document.getElementById('confirm-modal').classList.add('hidden');
      confirmCallback = null;
    }

    // ─── Auto-dismiss flash messages ───
    setTimeout(() => {
      const flash = document.getElementById('flash-msg');
      if (flash) {
        flash.style.transition = 'opacity 0.5s';
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 500);
      }
    }, 4000);
  </script>

  @yield('scripts')
</body>
</html>
