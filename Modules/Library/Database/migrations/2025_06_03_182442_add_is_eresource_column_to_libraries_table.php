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
        Schema::table('libraries', function (Blueprint $table) {
            if(!Schema::hasColumn('libraries', 'is_eresource')) {
                $table->boolean('is_eresource')->default(false)->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libraries', function (Blueprint $table) {
            if(Schema::hasColumn('libraries', 'is_eresource')) {
                $table->dropColumn('is_eresource');
            }
        });
    }
};
