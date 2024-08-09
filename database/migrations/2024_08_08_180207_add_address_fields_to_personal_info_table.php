<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsToPersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->string('street_address')->nullable()->after('contact_preference');
            $table->string('apt')->nullable()->after('street_address');
            $table->string('city')->nullable()->after('apt');
            $table->string('state')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->dropColumn(['street_address', 'apt', 'city', 'state', 'zip_code']);
        });
    }
}
