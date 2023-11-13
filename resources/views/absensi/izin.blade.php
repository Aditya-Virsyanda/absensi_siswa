@extends('dashboardd.template')
@section('contentt')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    @endsection
    
    @section('content')
    <div class="fab-button buttom-right position-absolute" style="bottom: 85px; right: 25px">
        <a href="/absensi/izinn" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>   
    @endsection