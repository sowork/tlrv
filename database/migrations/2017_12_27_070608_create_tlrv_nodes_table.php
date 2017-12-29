<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTlRVNodesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('tlrv_nodes', function(Blueprint $table) {
        $table->engine = 'innoDB';
        $table->increments('id');
        $table->unsignedInteger('parent_id')->nullable();
        $table->unsignedInteger('lft')->nullable();
        $table->unsignedInteger('rgt')->nullable();
        $table->unsignedInteger('depth')->nullable();

//        $table->unsignedInteger('parent_id')->default(0);
//        $table->unsignedInteger('lft')->default(0);
//        $table->unsignedInteger('rgt')->default(0);
//        $table->unsignedInteger('depth')->default(0);


        $table->string('node_key')->default('');
        $table->string('node_value')->default('');
        $table->index(['parent_id', 'lft', 'rgt', 'depth', 'node_value']);

        $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('tlrv_nodes');
  }

}
