<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printings', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('file_name');
            $table->string('path');
            $table->integer('employee');
            $table->integer('print_no');
            $table->integer('network');
            $table->integer('zone');
            $table->integer('institution');
            $table->integer('branch');
            $table->timestamp('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printings', function (Blueprint $table) {
            $table->drop();
        });
    }
}
