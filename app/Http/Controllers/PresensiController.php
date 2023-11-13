<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PresensiController extends Controller
{
    public function create(){
        $hariini = date("Y-m-d");
        $nik = Auth::guard('pegawai')->user()->nik;
        $cek = DB::table('presensis')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        return view('absensi.create',compact('cek'));
    }

    public function store(Request $request){
        $nik = Auth::guard('pegawai')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;

        $cek = DB::table('presensis')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if ($cek > 0) {
            $ket = "keluar";
        } else {
            $ket = "masuk";
        } 
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64" , $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        
        
        if($cek > 0){
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('presensis')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
            if ($update) {
                // echo 0;
                Storage::put($file, $image_base64);
    
                return response()->json([
                    "status" => "success",
                    "response" => "Hati Hati Dijalan",
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "response" => "Terjadi Error",
                ]);
            } 
        }else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
                ];
                $simpan = Presensi::create($data);
                if ($simpan) {
                    // echo 0;
                    Storage::put($file, $image_base64);
        
                    return response()->json([
                        "status" => "success",
                        "response" => "Selamat Belajar  ",
                    ]);
                } else {
                    return response()->json([
                        "status" => "error",
                        "response" => "Terjadi Error",
                    ]);
                } 
            }
        
         }
         
    public function editprofile(){
        $nik = Auth::guard('pegawai')->user()->nik;
        // dd($nik);
        $pegawai = DB::table('pegawais')->where('nik', $nik)->first();
        // dd($pegawai);
        return view('absensi.editprofile', compact('pegawai'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

            if(!empty($password)){
                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                ];
            } else {
                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'password'=> $password
                ];
            }
        $update = DB::table('pegawais')->where('nik', $nik)->update($data);
        // return view('dashboardd.dashboard');
        if ($update){
            return redirect()->route('dashboard');
        }else{
               // return view('absensi.create'); 
            return redirect()->route('dashboard');
        }

    }
    public function histori()
        {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.histori', compact('namabulan'));
        }
    public function gethistori(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('pegawai')->user()->nik;

        $histori = DB::table('presensis')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('absensi.gethistori', compact('histori'));
    
    }
    public function izin(){
        return view ('absensi.izin');
    }
    public function izinn(){
        return view ('absensi.izinn');
    }
    public function storeizin(Request $request){
        $nik = Auth::guard('pegawai')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('aproved_izin')->insert($data);

        if ($simpan){
            return redirect('/absensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/absensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }
}