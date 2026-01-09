<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //metodo para crear ese campo 
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal("price", 8,2); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //metodo para que elimine ese campo 
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn("price");
        });
    }
};
