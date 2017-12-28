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
        $table->unsignedInteger('parent_id')->default(0);
        $table->unsignedInteger('lft')->default(0);
        $table->unsignedInteger('rgt')->default(0);
        $table->unsignedInteger('depth')->default(0);

        $table->string('node_key');
        $table->string('node_value');
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
