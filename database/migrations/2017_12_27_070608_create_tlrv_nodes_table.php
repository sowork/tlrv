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
        $table->unsignedInteger('parent_id')->nullable()->index();
        $table->unsignedInteger('lft')->nullable()->index();
        $table->unsignedInteger('rgt')->nullable()->index();
        $table->unsignedInteger('depth')->nullable();

        $table->string('node_key')->default('');
        $table->string('node_value')->default('');

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
