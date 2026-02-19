@extends('layouts.admin')

@section('content')
   <div class="row">
    <div class="col-lg-8">
         <div class="card">
            <div class="card-header">Form Edit Data</div>
                <div class="card-body">
                    <form action="{{ route('admin.bayars.update', $bayar->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <div class="form-group">
                                <label for="namaku">Nama</label>
                                <input type="text" name="namaku"class="form-control"value="{{ old('namaku', $bayar->namaku) }}"> </input>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobilrental">Mobil</label>
                                <input type="text" name="mobilrental"class="form-control"value="{{ old('mobilrental', $bayar->mobilrental) }}"> </input>
                            </div>

                            <div class="form-group">
                                <label for="driverrental">Driver</label>
                                <input type="text" name="driverrental"class="form-control"value="{{ old('driverrental', $bayar->driverrental) }}"> </input>
                            </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    
                    </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
    <div class="card">
            <div class="card-header">Form Edit Gambar</div>
                <div class="card-body">
                    <form action="{{ route('admin.bayars.updateImage', $bayar->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <img src="{{ $bayar->bukti }}" class="img-fluid" alt="Bukti" style="border-radius: 12px;">
                        </div>
                        
                        <div class="form-group">
                            <label for="bukti">Gambar</label>
                            <input type="file"class="form-control"name="bukti">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    
                    </form>
            </div>
        </div>
    </div>
   </div>
@endsection