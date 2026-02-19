@extends('layouts.user')

@section('content')
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Daftar Mobil</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Gambar Mobil</th>
                            <th>Harga Mobil</th>
                            <th>Status Mobil</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                        <tr>
                            <td> {{$loop->iteration }}</td>
                            <td> {{$car->nama_mobil }}</td>
                            <td>
                                <img src="{{ $car->gambar }}" width="150" alt="{{ $car->nama_mobil }}" style="border-radius: 8px;">
                            </td>
                            <td> {{$car->harga_sewa }}</td>
                            <td> {{$car->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td coldspan="6" class="text-center">Data Kosong</td>
                        </tr>
                        @endforelse
                      </tbody>
                </table>
            </div>
        </div>
      </div>
@endsection




 



