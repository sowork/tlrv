<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTlrvNodeAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlrv_node_additions', function (Blueprint $table) {
            $table->engine = 'innoDB';
            $table->increments('id');
            $table->unsignedInteger('node_id');
            $table->text('addition_data');

            $table->timestamps();

            $table->foreign('node_id')->references('id')->on('tlrv_nodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlrv_node_additions');
    }
}
