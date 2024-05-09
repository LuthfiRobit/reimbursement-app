<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('karyawan.index');
    }

    public function list()
    {
        $data = User::select('id_user', 'name', 'nip', 'jabatan')
            ->get()
            ->map(
                function ($k) {
                    return [
                        'nip' => $k->nip,
                        'nama_karyawan' => $k->name,
                        'jabatan' => $k->jabatan,
                        'cek' => Crypt::encryptString($k->id_user),
                        'action' => Crypt::encryptString($k->id_user)
                    ];
                }
            );
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = User::where('id_user', $id)->first();
        if ($one) {
            // return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
            return $this->permissionService->successResponse('data ditemukan', $one);
        } else {
            // return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
            return $this->permissionService->errorResponse('data tidak ditemukan');
        }
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'nip' => 'required|min:16|max:16',
            'nama_karyawan' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|confirmed|min:6',
            'jabatan' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $saveKaryawan['nip'] = $request->nip;
            $saveKaryawan['email'] = $request->email;
            $saveKaryawan['name'] = $request->nama_karyawan;
            $saveKaryawan['jabatan'] = $request->jabatan;
            $saveKaryawan['password'] = Hash::make($request->password);
            User::create($saveKaryawan);
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $saveKaryawan);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nip' => 'required|min:16|max:16',
            'nama_karyawan' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'confirmed',
            'jabatan' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {

            $updateKaryawan['nip'] = $request->nip;
            $updateKaryawan['email'] = $request->email;
            $updateKaryawan['name'] = $request->nama_karyawan;
            $updateKaryawan['jabatan'] = $request->jabatan;

            if ($request->password != null || $request->password != '') {
                $updateKaryawan['password'] = Hash::make($request->password);
            }

            $findKaryawan =  User::where('id_user', $id)->first();
            $findKaryawan->update($updateKaryawan);

            DB::commit();
            return $this->permissionService->successResponse('data berhasil diperbarui', $updateKaryawan);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal diperbarui');
        }
    }

    public function destroy(string $id)
    {

        $id = Crypt::decryptString($id);
        $one = User::where('id_user', $id)->first();
        if ($one) {
            $one->delete();
            return $this->permissionService->successResponse('data berhasil dihapus', $one);
        } else {
            return $this->permissionService->errorResponse('data tidak ditemukan');
        }
    }
}
