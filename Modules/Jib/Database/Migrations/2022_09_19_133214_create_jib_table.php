<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJibTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_initiator', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->string('objid_posisi')->unique();
            $table->string('nama_posisi');
            $table->string('kode_unit');
            $table->string('nama_unit');
            $table->boolean('is_active')->default(1);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('m_pemeriksa', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('rules');
            $table->string('nik');
            $table->string('nama');
            $table->string('objid_posisi');
            $table->string('nama_posisi');
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('m_kategori', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
        });

        Schema::create('m_periode', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
        });

        Schema::create('jib_pengajuan', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('initiator_id');
            $table->integer('user_id');
            $table->string('nama_unit');
            $table->string('kegiatan')->nullable();
            $table->string('no_drp')->nullable();
            $table->string('rra')->nullable();
            $table->integer('kateogri');
            $table->string('status');
            $table->integer('periode');
            $table->float('nilai_capex')->nullable();
            $table->float('est_revenue')->nullable();
            $table->integer('irr')->nullable();
            $table->text('detail')->nullable();
            $table->string('file_jib')->nullable();
            $table->string('file_jib_asli')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('jib_reviewer', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('pengajuan_id');
            $table->integer('initiator_id');
            $table->string('urutan');
            $table->string('last_status');
        });

        Schema::create('jib_review', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('pengajuan_id');
            $table->integer('reviewer_id');
            $table->string('status');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_initiator');
        Schema::dropIfExists('m_pemeriksa');
        Schema::dropIfExists('m_kategori');
        Schema::dropIfExists('m_periode');
        Schema::dropIfExists('jib_pengajuan');
        Schema::dropIfExists('jib_reviewer');
        Schema::dropIfExists('jib_review');
        Schema::dropIfExists('jib_reviewer');
    }
}
