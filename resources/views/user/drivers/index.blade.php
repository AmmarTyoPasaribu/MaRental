@extends('layouts.user')

@section('content')

<div class="d-flex flex-row-reverse mt-4">
    <a style="background-color:#27005D;color: #E5CFF7;" href="{{ route('drivers.create') }}" class="btn btn-dark">Driver Baru</a>
</div>

<div class="row mt-3">
    @forelse($drivers as $driver)
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 15px;background-color:rgb(0,0,0,0.6);color:white;padding:4px">
                <img style="border-radius: 15px;" src="{{ $driver->gambar_sim }}" class="card-img-top" alt="{{ $driver->nama_driver }}">

                <div class="card-body">
                    <h5 class="card-title" style="color:white">{{ $driver->nama_driver }}</h5>
                    <p>{{$driver->gender}}</p>
                </div>

                <div>
              
                </div>
            </div>
        </div>
    @empty
        <p>No Driver Available.</p>
    @endforelse
</div>

@endsection
