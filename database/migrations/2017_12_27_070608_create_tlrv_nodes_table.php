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
        $table->increments('id');
        $table->unsignedInteger('parent_id');
        $table->unsignedInteger('lft');
        $table->unsignedInteger('rgt');
        $table->unsignedInteger('depth');

        $table->string('key');
        $table->string('value');
        $table->string('directory_name');
        $table->index(['parent_id', 'lft', 'rgt', 'depth', 'value']);

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
