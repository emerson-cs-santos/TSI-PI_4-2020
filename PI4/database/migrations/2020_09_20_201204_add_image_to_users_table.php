<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToUsersTable extends Migration
{
    public function up()
    {
        // text: 65,535 characters - 64 KB
        // mediumtext: 16,777,215 - 16 MB
        // longtext: 4,294,967,295 characters - 4 GB

        Schema::table('users', function (Blueprint $table) {
            $table->mediumText('image')->default('');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
