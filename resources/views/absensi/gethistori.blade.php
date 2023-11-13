@if ($histori->isEmpty())
    <div class="alert alert-warning d-flex justify-content-center align-items-end"><p class="m-0">Data Belum Ada</p></div>
@endif
@foreach ($histori as $d)
    {{-- <p>{{$d->tgl_presensi}}</p> --}}
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi/'.$d->foto_in);
                @endphp
                <img src="{{url($path)}}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{date("d-m-Y",strtotime($d->tgl_presensi))}}</b><br>
                    </div>
                    <span class="badge badge-success">{{$d->jam_in}}</span>
                    <span class="badge badge-danger">{{$d->jam_out}}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach