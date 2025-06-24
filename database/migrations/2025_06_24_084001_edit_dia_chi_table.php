<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dia_chi', function(Blueprint $table){
            $table->boolean('is_default_address')->default(0)->comment('0 là bình thường, 1 là địa chỉ mặc định')->after('an_hien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dia_chi', function(Blueprint $table){
            $table->dropColumn('is_default_address');
        });
    }
};
