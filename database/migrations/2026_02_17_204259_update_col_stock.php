<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  $table->decimal('precio', 12, 2)->change();
    *  $table->dropColumn('stock');
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->renameColumn('stock', 'cantidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->renameColumn('cantidad', 'stock');
        });
    }
};
