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
        Schema::table('permissions', function (Blueprint $table) {
            if(!Schema::hasColumn('permissions', 'display_name')) {
                $table->string("display_name")->nullable()->after("name");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if(Schema::hasColumn('permissions', 'display_name')) {
                $table->dropColumn("display_name");
            }
        });
    }
};
