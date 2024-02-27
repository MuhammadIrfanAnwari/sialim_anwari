<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\tampilan;
use App\Models\bagian;
use App\Models\dokumen;
use App\Models\kriteria;
use App\Models\pengunjung;
use App\Models\downloaded;
use App\Models\User;
use ZipArchive;
use Storage;
use File;
use Log;
class TamuController extends Controller
{
    public function index(Request $request){
        $data['data_bagian'] = ['1'];

        if($request->filter_bagian){
            $data['data_bagian'] = $request->filter_bagian;
        }
        
        if(tampilan::orderBy('id', 'desc')->first()){
            $data['init'] = tampilan::orderBy('id', 'desc')->first();
        } else {
            return redirect()->route('initialization.index')->with(['danger'=>'Silahkan melakukan inisialisasi terlebih dahulu!']);
        }

        $dokumen_count = dokumen::join('sub_kriterias', 'id_sub_kriteria', 'sub_kriterias.id')
                                ->join('kriterias', 'id_kriteria', 'kriterias.id')
                                ->get()
                                ->groupBy('id_kriteria');

        $data['dokumenMonth'] = dokumen::where('created_at', 'LIKE', '%'.date('Y-m').'%')->get()->count();

        $data['kriteria'] = kriteria::orderBy('nama_kriteria', 'ASC')->get();

        $data['pengunjung'] = pengunjung::all()->count();
        $data['pengunjungToday'] = pengunjung::where('tanggal', 'LIKE', '%'.date('Y-m-d').'%')->get()->count();

        $data['downloaded'] = downloaded::all()->count();
        $data['downloadedToday'] = downloaded::where('tanggal', 'LIKE', '%'.date('Y-m-d').'%')->get()->count();

        $kolek = $data['kriteria']->toArray();
        $dokumen_count = $dokumen_count->values();
        
        $j = 0;
        $jumlah = 0;
        for($i = 0; $i < $dokumen_count->count(); $i++){
            $jumlah += $dokumen_count[$i]->count();
        }
        $data['dokumen_count'][] = [
            'nama_kriteria'=>'Total',
            'singkatan'=>"<i class='fas fa-database'></i>",
            'jumlah'=>$jumlah,
        ];
        
        for($i = 0; $i < $data['kriteria']->count(); $i++){
            if($kolek[$i]['id'] == $dokumen_count[$j][0]['id']){
                $data['dokumen_count'][] = [
                    'nama_kriteria'=>$kolek[$i]['nama_kriteria'],
                    'singkatan'=>$kolek[$i]['singkatan'],
                    'jumlah'=>$dokumen_count[$j]->count(),
                ];
                if($j < $dokumen_count->count()-1){
                    $j += 1;
                } else {
                    $j = 0;
                }
            } else {
                $data['dokumen_count'][] = [
                    'nama_kriteria'=>$kolek[$i]['nama_kriteria'],
                    'singkatan'=>$kolek[$i]['singkatan'],
                    'jumlah'=>0,
                ];
            }
        }

        $data['dokumen'] = kriteria::with('sub_kriteria.dokumen')->orderBy('nama_kriteria', 'asc')->get();
        
        $data['filter_bagian'] = bagian::all();
        
        return view('tamu.index', $data);
    }

    public function token(Request $request){
        if(File::exists(public_path('zip/sialim.zip')))
        {
            File::delete(public_path('zip/sialim.zip'));
        }
        $data = $request->validate([
            'remember_token'=>'required'
        ]);

        $user = User::with('perizinan.dokumen')->where('remember_token', '=', $data['remember_token'])->first();
        if($user == null){
            return redirect()->route('tamu.index')->with(['danger'=>'Token tidak ditemukan']);
        } else if($user->masa_berlaku < date('Y-m-d')){
            return redirect()->route('tamu.index')->with(['danger'=>'Masa berlaku telah habis. Silahkan hubungi admin!!']);
        }
        // dd($user->perizinan[2]->dokumen->dokumen);
        
        
        $zip = new ZipArchive;
        $directory = public_path('files');

        $zipFile = public_path('zip/sialim.zip');

        // dd($user->perizinan);

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            for($i = 0; $i < count($user->perizinan); $i++){
                $dokumen = dokumen::find($user->perizinan[$i]->id_dokumen);
                $downloaded['ip'] = \Request::ip();
                $downloaded['id_dokumen'] = $dokumen->id;
                $downloaded['tanggal'] = date('Y-m-d');
                downloaded::create($downloaded);
                $file = File::get(storage_path('app/private/'.$dokumen->dokumen));
                // dd($dokumen->dokumen);

                $extensi = explode('.', $dokumen->dokumen);
                // $zip->addFile(storage_path('app/private/'.$dokumen->dokumen), $dokumen->judul.'.pdf');
                if(end($extensi) == 'pdf'){
                    $zip->addFile(storage_path('app/private/'.$dokumen->dokumen), $dokumen->judul.'.pdf');
                } else if(end($extensi) == 'xlsx'){
                    $zip->addFile(storage_path('app/private/'.$dokumen->dokumen), $dokumen->judul.'.xlsx');
                }
            }
           
            
            // Close the zip file
            $zip->close();
        }

        return response()->download($zipFile);
        // return redirect()->route('tamu.index');
    }

    public function download(String $id){
        $dokumen = dokumen::find($id);
        if ($dokumen['privasi'] == 'public') {
            $downloaded['ip'] = \Request::ip();
            $downloaded['id_dokumen'] = $id;
            $downloaded['tanggal'] = date('Y-m-d');
            downloaded::create($downloaded);

            return Storage::download('private/'.$dokumen['dokumen'], $dokumen->judul);
        }
        return redirect()->route('tamu.index')->with(['danger'=>'Gagal mendownload file '.$dokumen['judul']]);
    }
}
