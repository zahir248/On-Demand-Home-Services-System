<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing unique constraint before modifying the column
            $table->dropUnique('users_phone_unique');

            // Modify the phone column to be nullable and unique
            $table->string('phone', 20)->nullable()->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert changes by making it non-nullable
            $table->string('phone', 20)->unique()->change();
        });
    }
};
