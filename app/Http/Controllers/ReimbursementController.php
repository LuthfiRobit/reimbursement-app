<?php

namespace App\Http\Controllers;

use App\Models\Reimbursement;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class ReimbursementController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function home()
    {
        $get = Reimbursement::select(
            'id_reimbursement',
            'user_id',
            'nominal_reimbursement',
            'status',
        )
            ->when(Auth::user()->jabatan == 'STAFF', function ($s) {
                $s->where('user_id', Auth::user()->id_user);
            })
            ->get();
        $data['pengajuan'] = $get->where('status', 'PENGAJUAN')->count();
        $data['diterima_direktur'] = $get->where('status', 'DITERIMA DIREKTUR')->count();
        $data['ditolak_direktur'] = $get->where('status', 'DITOLAK DIREKTUR')->count();
        $data['diterima_finance'] = $get->where('status', 'DITERIMA FINANCE')->count();
        $data['ditolak_finance'] = $get->where('status', 'DITOLAK FINANCE')->count();
        // return $data;
        return view('home', $data);
    }

    public function index()
    {
        return view('reimbursement.index');
    }

    public function list()
    {
        $data = Reimbursement::select(
            'id_reimbursement',
            'user_id',
            'nama_reimbursement',
            'tanggal_reimbursement',
            'nominal_reimbursement',
            'status',
        )
            ->when(Auth::user()->jabatan == 'STAFF', function ($s) {
                $s->where('user_id', Auth::user()->id_user);
            })
            ->when(Auth::user()->jabatan == 'FINANCE', function ($s) {
                $s->where('status', 'DITERIMA DIREKTUR')->orWhere('status', 'DITERIMA FINANCE')->orWhere('status', 'DITOLAK FINANCE');
            })
            ->orderBy('tanggal_reimbursement', 'DESC')
            ->get()
            ->map(
                function ($r) {
                    return [
                        'id_reimbursement' => $r->id_reimbursement,
                        'nama_karyawan' => $r->karyawan->name,
                        'nama_reimbursement' => $r->nama_reimbursement,
                        'tanggal_reimbursement' => Carbon::parse($r->tanggal_reimbursement)->format('d F Y'),
                        'nominal_reimbursement' => $r->nominal_reimbursement,
                        'status' => $r->status,
                        'cek' => Crypt::encryptString($r->id_reimbursement),
                        'action' => Crypt::encryptString($r->id_reimbursement)
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
        $one = Reimbursement::select(
            'id_reimbursement',
            'user_id',
            'nama_reimbursement',
            'tanggal_reimbursement',
            'file_reimbursement',
            'nominal_reimbursement',
            'keterangan',
            'deskripsi_reimbursement',
            'status',
        )->where('id_reimbursement', $id)
            ->with(['karyawan' => function ($k) {
                $k->select('id_user', 'nip', 'name', 'jabatan');
            }])
            ->first();
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
            'nama_reimbursement' => 'required',
            'tanggal_reimbursement' => 'required',
            'nominal_reimbursement' => 'required',
            'file_reimbursement' => 'required|mimes:jpg,png,pdf'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file_reimbursement');
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $saveReimbursement['user_id'] = Auth::user()->id_user; // change into auth user id for the next
            $saveReimbursement['nama_reimbursement'] = $request->nama_reimbursement;
            $saveReimbursement['tanggal_reimbursement'] = $request->tanggal_reimbursement;
            $saveReimbursement['deskripsi_reimbursement'] = $request->deskripsi_reimbursement;
            $saveReimbursement['nominal_reimbursement'] = $request->nominal_reimbursement;
            $saveReimbursement['file_reimbursement'] = $fileName;
            $saveReimbursement['status'] = "PENGAJUAN";
            Reimbursement::create($saveReimbursement);
            $request->file_reimbursement->move(public_path('files'), $fileName);
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $saveReimbursement);
        } catch (\Throwable $th) {
            //throw $th;
            // File::delete('files/' . $fileName);
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function update(Request $request, string $id)
    {

        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_reimbursement' => 'required',
            'tanggal_reimbursement' => 'required',
            'file_reimbursement' => 'mimes:jpg,png,pdf'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }
        DB::beginTransaction();
        try {

            $updateReimbursement['nama_reimbursement'] = $request->nama_reimbursement;
            $updateReimbursement['tanggal_reimbursement'] = $request->tanggal_reimbursement;
            $updateReimbursement['deskripsi_reimbursement'] = $request->deskripsi_reimbursement;
            $updateReimbursement['nominal_reimbursement'] = $request->nominal_reimbursement;
            $updateReimbursement['status'] = "PENGAJUAN";

            $findReimbursement =  Reimbursement::where('id_reimbursement', $id)->first();
            //if file is exist
            if ($request->hasFile('file_reimbursement')) {
                //check previouse file
                if (!is_null($findReimbursement->file_reimbursement)) {
                    File::delete('files/' . $findReimbursement->file_reimbursement);
                }
                //store new file
                $file = $request->file('file_reimbursement');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $updateReimbursement['file_reimbursement'] = $fileName;
                $request->file_reimbursement->move(public_path('files'), $fileName);
            }

            $findReimbursement->update($updateReimbursement);

            DB::commit();
            return $this->permissionService->successResponse('data berhasil diperbarui', $updateReimbursement);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal diperbarui');
        }
    }

    public function destroy(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = Reimbursement::where('id_reimbursement', $id)->first();
        if ($one) {
            if (!is_null($one->file_reimbursement)) {
                File::delete('files/' . $one->file_reimbursement);
            }
            $one->delete();
            return $this->permissionService->successResponse('data berhasil dihapus', $one);
        } else {
            return $this->permissionService->errorResponse('data tidak ditemukan');
        }
    }

    public function approve(Request $request)
    {
        $id = Crypt::decryptString($request->id_reimbursement);
        if (Auth::user()->jabatan === 'DIREKTUR') {
            if ($request->status === 'y') {
                $status = 'DITERIMA DIREKTUR';
            } else {
                $status = 'DITOLAK DIREKTUR';
            }
        }
        if (Auth::user()->jabatan === 'FINANCE') {
            if ($request->status === 'y') {
                $status = 'DITERIMA FINANCE';
            } else {
                $status = 'DITOLAK FINANCE';
            }
        }

        $updateReimbursement['keterangan'] = $request->keterangan;
        $updateReimbursement['status'] = $status;
        $one = Reimbursement::where('id_reimbursement', $id)->first();
        $one->update($updateReimbursement);
        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function approveMultiple(Request $request)
    {
        foreach ($request->id_reimbursement as $row) {
            if (Auth::user()->jabatan === 'DIREKTUR') {
                if ($request->status === 'y') {
                    $status = 'DITERIMA DIREKTUR';
                } else {
                    $status = 'DITOLAK DIREKTUR';
                }
            }

            if (Auth::user()->jabatan === 'FINANCE') {
                if ($request->status === 'y') {
                    $status = 'DITERIMA FINANCE';
                } else {
                    $status = 'DITOLAK FINANCE';
                }
            }

            $updateReimbursement['status'] = $status;
            $one = Reimbursement::where('id_reimbursement', $row)->first();
            $one->update($updateReimbursement);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }
}
