<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MaRental Admin</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-dark-900 text-white min-h-screen">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 glass-card border-r border-white/10 flex-shrink-0 flex flex-col fixed h-full z-40 transition-transform -translate-x-full lg:translate-x-0">
      <!-- Brand -->
      <div class="px-6 py-5 border-b border-white/10">
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl gradient-btn flex items-center justify-center">
            <i class="bi bi-speedometer2 text-white text-lg"></i>
          </div>
          <div>
            <h1 class="text-lg font-black"><span class="text-brand-400">MaR</span>ental</h1>
            <p class="text-[10px] text-white/40 uppercase tracking-widest">Admin Panel</p>
          </div>
        </a>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <p class="px-3 text-[10px] font-bold text-white/30 uppercase tracking-widest mb-2">Menu Utama</p>
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard.*') ? 'bg-brand-600/20 text-brand-400 border border-brand-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all">
          <i class="bi bi-grid-1x2-fill text-base"></i> Dashboard
        </a>
        <a href="{{ route('admin.cars.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.cars.*') ? 'bg-brand-600/20 text-brand-400 border border-brand-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all">
          <i class="bi bi-car-front-fill text-base"></i> Kendaraan
        </a>
        <a href="{{ route('admin.drivers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.drivers.*') ? 'bg-brand-600/20 text-brand-400 border border-brand-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all">
          <i class="bi bi-person-badge-fill text-base"></i> Driver
        </a>
        <a href="{{ route('admin.bayars.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.bayars.*') ? 'bg-brand-600/20 text-brand-400 border border-brand-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all">
          <i class="bi bi-receipt text-base"></i> Rental Aktif
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-brand-600/20 text-brand-400 border border-brand-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all">
          <i class="bi bi-people-fill text-base"></i> Users
        </a>
      </nav>

      <!-- Footer -->
      <div class="px-3 py-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}" id="admin-logout">
          @csrf
          <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all">
            <i class="bi bi-box-arrow-left text-base"></i> Logout
          </button>
        </form>
      </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64">
      <!-- Topbar -->
      <header class="sticky top-0 z-20 glass border-b border-white/10">
        <div class="flex items-center justify-between px-4 lg:px-8 py-3">
          <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-white/60 hover:text-white hover:bg-white/10">
            <i class="bi bi-list text-xl"></i>
          </button>
          <div class="flex items-center gap-3">
            <a href="{{ route('homepage') }}" class="text-xs text-white/40 hover:text-brand-400 transition-colors">
              <i class="bi bi-house me-1"></i> Ke Homepage
            </a>
            <span class="text-white/20">|</span>
            <span class="text-sm font-medium text-white/60">
              <i class="bi bi-person-circle me-1"></i> {{ session('supabase_user')['name'] ?? 'Admin' }}
            </span>
          </div>
        </div>
      </header>

      <!-- Content -->
      <main class="p-4 lg:p-8">
        <!-- Flash Messages -->
        @if(session()->has('message'))
        <div id="flash-msg" class="mb-6 rounded-xl px-5 py-3 text-sm font-medium flex items-center justify-between animate-fade-in
          {{ session()->get('alert-type') === 'success' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : '' }}
          {{ session()->get('alert-type') === 'info' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : '' }}
          {{ session()->get('alert-type') === 'danger' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : '' }}">
          <span><i class="bi bi-check-circle-fill me-2"></i>{{ session()->get('message') }}</span>
          <button onclick="this.parentElement.remove()" class="text-white/50 hover:text-white"><i class="bi bi-x-lg"></i></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-500/20 border border-red-500/30 p-4 animate-fade-in">
          <ul class="text-red-300 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('-translate-x-full');
      document.getElementById('sidebar-overlay').classList.toggle('hidden');
    }
    // Auto-dismiss flash
    setTimeout(() => {
      const f = document.getElementById('flash-msg');
      if (f) { f.style.transition='opacity .5s'; f.style.opacity='0'; setTimeout(()=>f.remove(),500); }
    }, 4000);
  </script>
</body>
</html>