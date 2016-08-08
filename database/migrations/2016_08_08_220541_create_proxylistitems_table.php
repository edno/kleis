<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxylistitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxylistitems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->unique();
            $table->boolean('whitelist')->default(true);
            $table->enum('type', ['domain', 'url']);
            $table->integer('created_by')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proxylistitems');
    }
}
