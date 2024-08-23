<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoLemburToLemburs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lemburs', function (Blueprint $table) {
            $table->text('info_lembur')->nullable()->after('total_lembur');
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
            $table->dropColumn('info_lembur');
        });
    }
}
