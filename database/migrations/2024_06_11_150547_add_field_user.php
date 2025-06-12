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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('idgroup')->after('password')->default(0);
            $table->string('diachi', 100)->after('idgroup')->nullable();
            $table->integer('sdt')->after('diachi')->nullable();
            $table->string('hinh', 255)->after('sdt')->nullable();
            $table->string('googleid', 255)->after('hinh')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
