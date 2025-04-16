<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToMobilsTable extends Migration
{
    public function up()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->after('seat')->nullable(); // bisa disesuaikan
        });
    }

    public function down()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
}
