<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Validator;
use PDF;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home','user']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level,'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('aksi', function ($user) {
            // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a>';
            // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn mx-4 btn-warning btn-sm">Edt</a>';
            // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
            //         . csrf_field() . method_field('DELETE') .  
            //         '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button>
            //         </form>';
            $btn  = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                    
            return $btn; 
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home','User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user Berhasil disimpan');
    }

    public function show(String $id) {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home','User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home','User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user Berhasil diubah');
    }

    public function destroy(string $id) {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user Berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax() {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors()
                ]);
            }
    
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user Berhasil disimpan'
            ]);
    
        }
        
        redirect('/');
    }

    public function edit_ajax(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors()
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if($request->filled('password')) {
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'success' => 'Data Berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

        }
        return redirect('/user');
    }

    public function confirm_ajax(string $id) {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/user');
    }

    public function show_ajax(string $id) {
        $user = UserModel::find($id);
        return view('user.show_ajax', ['user' => $user]);
    }
    
    public function import(){
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];

            if(count($data) > 1){ // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if($baris > 1){ // baris ke 1 adalah header, maka lewati
                            $insert[] = [
                            'user_id' => $value['A'],
                            'level_id' => $value['B'],
                            'username' => $value['C'],
                            'nama' => $value['D'],
                            'password' => Hash::make($value['E']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if(count($insert) > 0){
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    UserModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }
    
    public function export_excel() {
        $user = UserModel::select('user_id', 'level_id', 'username', 'nama')
                    ->orderBy('level_id')
                    ->with('level')
                    ->get();
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Level User');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        
        $no = 1;
        $baris = 2;

        foreach ($user as $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->username);
            $sheet->setCellValue('C'.$baris, $value->nama);
            $sheet->setCellValue('D'.$baris, $value->level->level_nama);
            $baris++;
            $no++;
        }
        
        foreach(range('A', 'D') as $columnId) {
            $sheet->getColumnDimension($columnId)->setAutoSize(true);
        }

        $sheet->setTitle('Data User');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_User_'.date('Y-m-d_H-i-s').'.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf() {
        $user = UserModel::select('user_id', 'level_id', 'username', 'nama')
                    ->orderBy('level_id')
                    ->with('level')
                    ->get();

        $pdf = PDF::loadView('user.export_pdf', ['user' => $user]);   
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", true); // jika ada gambar
        $pdf->render();

        return $pdf->stream('Data User '.date('Y-m-d_H-i-s').'.pdf');
    }
}
