@extends('layouts.admin')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-black"><i class="bi bi-people me-2 text-brand-400"></i>Daftar Users</h1>
  <p class="text-white/40 text-sm mt-1">Kelola pengguna terdaftar</p>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-white/10 bg-white/5">
          <th class="px-4 py-3 text-left text-white/50 font-medium">No</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Nama</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Email</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Role</th>
          <th class="px-4 py-3 text-left text-white/50 font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-white/5">
        @php $counter = 0; @endphp
        @forelse($users as $user)
        @if(!$user->is_admin)
        @php $counter++; @endphp
        <tr class="hover:bg-white/5 transition-colors">
          <td class="px-4 py-3 text-white/40">{{ $counter }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-brand-500/20 flex items-center justify-center">
                <i class="bi bi-person-fill text-brand-400 text-sm"></i>
              </div>
              <span class="font-medium">{{ $user->name }}</span>
            </div>
          </td>
          <td class="px-4 py-3 text-white/60">{{ $user->email }}</td>
          <td class="px-4 py-3">
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400">User</span>
          </td>
          <td class="px-4 py-3">
            <form onsubmit="return confirm('Hapus user ini?')" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
              @csrf @method('delete')
              <button class="px-3 py-1.5 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
        @endif
        @empty
        <tr><td colspan="5" class="px-4 py-8 text-center text-white/30">Belum ada user terdaftar</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
