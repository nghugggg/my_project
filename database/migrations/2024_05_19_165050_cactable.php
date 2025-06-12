<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danhMuc', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 50);
            $table->boolean('thuTu')->default(0);
            $table->boolean('anHien')->default(1);
            $table->timestamps();
        });
        Schema::create('tinhChat', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 50);
            $table->timestamps();
        });
        Schema::create('sanPham', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 255);
            $table->integer('idDanhMuc');
            $table->integer('gia')->default(0);
            $table->integer('giaKm')->default(0);
            $table->string('hinh', 255)->nullable();
            $table->date('ngay')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('luotXem')->default(0);
            $table->integer('hot')->default(0);
            $table->boolean('anHien')->default(1);
            $table->boolean('tinhChat')->default(0);
            $table->string('mauSac', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danhMuc');
        Schema::dropIfExists('tinhChat');
        Schema::dropIfExists('sanPham');
    }
};
