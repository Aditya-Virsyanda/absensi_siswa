<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprovedIzin extends Model
{
    use HasFactory;
    protected $table = "aproved_izin";
    protected $primaryKey = "nik";
    protected $fillable = [
        'nik',
        'tgl_izin',
        'status',
        'keterangan',
        'status_aproved',
    ];
}
