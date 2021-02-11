<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusablesTable extends Migration
{
    public function up()
    {
        Schema::create('statusables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('status'))->index();
            $table->morphs('statusable');
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->timestamps();
        });
    }
}
