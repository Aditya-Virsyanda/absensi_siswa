<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\View;

class DashboardController extends Controller
{
    function index () {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; 
        $tahunini = date("Y");
        $nik = Auth::guard('pegawai')->user()->nik;
        $presensihariini = DB::table('presensis')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensis')->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
         ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
         ->where('nik', Auth::user()->nik)
         ->orderBy('tgl_presensi')
         ->get();
        $rekappresensi = DB::table('presensis')
        ->selectRaw('COUNT(nik) as jmlhadir')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
        ->first();
        $leaderboard = DB::table('presensis')
        ->join('pegawais', 'presensis.nik', '=', 'pegawais.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();
    $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    return view ('dashboardd.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard'));
    }
}
