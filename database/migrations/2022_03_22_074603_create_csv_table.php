<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvTable extends Migration
{
    /**
     * Запустить миграцию.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv', function (Blueprint $table) {
            $table->id();
            $table->string('year')->default('');
            $table->string('industry_code')->default('');
            $table->string('industry_name')->default('');
            $table->string('rme_size_grp')->default('');
            $table->string('variable')->default('');
            $table->string('value')->default('');
            $table->string('unit')->default('');
            $table->timestamps();
        });
    }

    /**
     * Обратить миграции.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('csv');
    }
}
