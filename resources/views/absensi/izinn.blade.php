@extends('dashboardd.template')
@section('contentt')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
    @endsection
    @section('content')
        <div class="row" style="margin-top:90px">
            <div class="col">
            <form method="POST" action="/absensi/storeizin" id="frmIzin">
                @csrf
                        <div class="form-group">
                            <input type="text" id="tgl_izin" name="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
                        </div>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="">Izin / Sakit</option>
                                <option value="i">Izin</option>
                                <option value="s">Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w100">Kirim</button>
                        </div>
                </form>
             </div>            
        </div>
    @endsection
    @push('myscript')
        <script>
            var currYear = (new Date()).getFullYear();
            $(document).ready(function() {
            $(".datepicker").datepicker({
                defaultDate: new Date(currYear-0,1,31),
                // setDefaultDate: new Date(2000,01,31),
                maxDate: new Date(currYear-0,12,31),
                yearRange: [1990, currYear-0],
                format: "yyyy/mm/dd"    
            });
            $("#frmIzin").submit(function(){
                var tgl_izin = $("tgl_izin").val();
                var status = $("$status").val();
                var keterangan = $("$keterangan").val();
                if (tgl_izin == ""){
                    Swal.fire({
                        title: 'Oops !'
                        , text: 'Tanggal harus diisi'
                        , icon: 'warning'
                    });
                    return false;
                } else if (status == "") {
                    Swal.fire({
                        title: 'Oops !'
                        , text: 'Status harus diisi'
                        , icon: 'warning'
                    });
                    return false;
                }else if (keterangan == ""){
                    Swal.fire({
                        title: 'Oops !'
                        , text: 'Keterangan harus diisi'
                        , icon: 'warning'
                    });
                    return false;
                }
            });
            });
        </script>
    @endpush    