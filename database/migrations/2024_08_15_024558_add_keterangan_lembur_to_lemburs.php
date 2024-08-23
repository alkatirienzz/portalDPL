<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganLemburToLemburs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lemburs', function (Blueprint $table) {
            $table->text('keterangan_lembur')->nullable()->after('total_lembur'); // Tambahkan kolom keterangan_lembur
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lemburs', function (Blueprint $table) {
            $table->dropColumn('keterangan_lembur');
        });
    }
}
