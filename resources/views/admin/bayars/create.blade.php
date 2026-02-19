@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Form Bayar</div>
        <div class="card-body">
            <form action="{{ route('admin.bayars.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="namaku">Nama</label>
                    <input type="text" name="namaku"class="form-control"value="{{ old('namaku') }}"> </input>
                </div>
                
                <div class="form-group">
                    <label for="mobilrental">Mobil</label>
                    <input type="text" name="mobilrental"class="form-control"value="{{ old('mobilrental') }}"> </input>
                </div>

                <div class="form-group">
                    <label for="driverrental">Driver</label>
                    <input type="text" name="driverrental"class="form-control"value="{{ old('driverrental') }}"> </input>
                </div>
            <div class="form-group">
                <label for="bukti">SimKtpBukti</label>
                <input type="file"class="form-control"name="bukti">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">simpan</button>
            </div>
          
            </form>
        </div>
    </div>
@endsection