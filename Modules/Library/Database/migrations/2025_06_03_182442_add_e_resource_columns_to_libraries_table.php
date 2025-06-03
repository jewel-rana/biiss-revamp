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
            if(!Schema::hasColumn('libraries', 'has_e_resource')) {
                $table->boolean('has_e_resource')->default(false)->index();
            }
            if(!Schema::hasColumn('libraries', 'e_resource_only')) {
                $table->boolean('e_resource_only')->default(false)->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libraries', function (Blueprint $table) {
            if(Schema::hasColumn('libraries', 'has_e_resource')) {
                $table->dropColumn('has_e_resource');
            }
            if(Schema::hasColumn('libraries', 'e_resource_only')) {
                $table->dropColumn('e_resource_only');
            }
        });
    }
};
