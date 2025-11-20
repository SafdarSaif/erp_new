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
        Schema::table('documents', function (Blueprint $table) {
            // 1. Drop foreign key first
            $table->dropForeign(['university_id']);

            // 2. Change column type
            $table->json('university_id')->change();

            // 3. Change acceptable_type also
            $table->json('acceptable_type')->change();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // revert back
            $table->string('acceptable_type')->change();
            $table->unsignedBigInteger('university_id')->change();

            // re-add FK
            $table->foreign('university_id')->references('id')->on('universities');
        });
    }
};
