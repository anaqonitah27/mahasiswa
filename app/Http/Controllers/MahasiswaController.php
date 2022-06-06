<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use App\Models\Matakuliah;
class MahasiswaController extends Controller{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function index(){
        //fungsi eloquent menampilkan data menggunakan pagination
             $mahasiswa = Mahasiswa::with('kelas')->latest('nim')->paginate(3);
             return view('mahasiswa.index', compact('mahasiswa'));
        }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    public function store(Request $request)
    { 
        //melakukan validasi data
        $validatedData = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TanggalLahir'=> 'required',
        ]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get("Kelas");
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggalLahir = $request->get('TanggalLahir');
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    public function show($Nim){
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
            $mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }

    public function edit($nim){
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();;
            $kelas = Kelas::all();
            return view('mahasiswa.edit', compact('mahasiswa','kelas'));
    }

    public function update(Request $request, $nim){
        //melakukan validasi data
            $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required', 
            'Email' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required',
            ]);
        //fungsi eloquent untuk mengupdate data inputan kita
            Mahasiswa::where('nim', $nim)->firstOrFail()->update($request->all());
        //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    public function destroy($nim){
    //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $nim)->firstOrFail()->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswa = Mahasiswa::where('nama', 'like', '%' . $keyword . '%')->paginate(4);
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function nilai($id_mahasiswa)
    {
        // Join relasi ke mahasiswa dan mata kuliah
        $mhs = Mahasiswa_MataKuliah::with('matakuliah')->where("mahasiswa_id", $id_mahasiswa)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where("nim", $id_mahasiswa)->first();
        //dd($mhs[0]);
        // Menampilkan nilai
        return view('mahasiswa.nilai', compact('mhs'));
    }
};
