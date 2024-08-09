<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->integer('selection')->nullable()->after('contact_preference');
        });
    }

    public function down()
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->dropColumn('selection');
        });
    }

};
