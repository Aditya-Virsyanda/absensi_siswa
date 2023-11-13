@extends('dashboardd.template')
@section('contentt')

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-PRESENSI</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video{
            display: inline-block;
            width: 70% !important;
            /* height: 100px !important; */
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }
        #map { height: 180px; }
    </style>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col-12">
            <input type="hidden" id="lokasi">
             <div class="webcam-capture d-flex justify-content-center "></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block my-4"><ion-icon name="camera-outline"></ion-icon>Pulang</button>   
                
            @else
            <button id="takeabsen" class="btn btn-primary btn-block my-4"><ion-icon name="camera-outline"></ion-icon>Masuk</button>
                
            @endif
        </div>
    </div>
    <div class="row mt-2 justify-content-center pb-5" style="margin-bottom: 100px !important">
        <div class="col-8">
        <div id="map" class="pb-5" style="height: 500px !important"></div>
    </div>
{{-- </div> --}}
@endsection

@push('myscript')
<script>
        Webcam.set({
            height: 480
            , width: 640
            , image_format: 'jpeg'
            , jpeg_quaity: 80
        });

        Webcam.attach('.webcam-capture');

        // console.log(navigator.geolocation.getCurrentPosition());

        var lokasi = document.getElementById('lokasi');
        console.log(navigator.geolocation);
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }



        function successCallback(position){
            lokasi.value = position.coords.latitude + "," + position.coords.longitude; 
            var map = L.map('map').setView([position.coords.latitude,position.coords.longitude], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19, attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map)
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'orange'
                , fillColor: '#f03'
                , fillopacity: 0.5
                , radius: 20
            }).addTo(map);  
            
            // console.log(map);
        }
        
        function errorCallback(){

        }
        $("#takeabsen").click(function(e){
            Webcam.snap(function(uri){
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST'
                , url: '/absensi/store'
                , data: {
                    _token: "{{csrf_token()}}"
                    , image: image
                    , lokasi: lokasi
                }
                , cache: false
                , success: function(data) {
                    if(data.status == "success"){
                        Swal.fire({
                            title: 'Berhasil Absen',
                            text: data.response,
                            icon: 'success'
                        })
                        setTimeout("location.href='/dashboard'", 2000);
                    }else{
                        Swal.fire({
                            title: 'Gagal Absen',
                            text: 'Silahkan Hubungi Teknisi!!',
                            icon: 'Error'
                        })
                    }
                        // alert(data.respons);
                        
                }
            })
        });
    </script>
@endpush