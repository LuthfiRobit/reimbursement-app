<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reimbursement', function (Blueprint $table) {
            $table->integer('id_reimbursement')->autoIncrement()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('nama_reimbursement', 150);
            $table->date('tanggal_reimbursement')->nullable();
            $table->integer('nominal_reimbursement')->nullable();
            $table->text('deskripsi_reimbursement')->nullable();
            $table->string('file_reimbursement', 36)->nullable();
            $table->enum('status', ['PENGAJUAN', 'DITOLAK DIREKTUR', 'DITOLAK FINANCE', 'DITERIMA DIREKTUR', 'DITERIMA FINANCE'])->default('PENGAJUAN');
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('reimbursement', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement');
    }
};
