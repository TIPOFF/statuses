<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name')->unique();
            $table->string('applies_to')->default('order'); // Values include 'order', 'slot', 'game', 'invoice', 'payment'
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
}
