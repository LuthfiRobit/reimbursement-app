<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reimbursement extends Model
{
    use HasFactory;

    protected $table        = 'reimbursement';

    protected $primaryKey   = 'id_reimbursement';

    protected $fillable = [
        'user_id',
        'nama_reimbursement',
        'tanggal_reimbursement',
        'deskripsi_reimbursement',
        'file_reimbursement',
        'nominal_reimbursement',
        'status',
        'keterangan'
    ];

    /**
     * Get the user that owns the Reimbursement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
