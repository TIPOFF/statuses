<?php

declare(strict_types=1);

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
            $table->string('name');
            $table->string('type');     // Typically, full class name for model using status
            $table->text('note')->nullable();
            $table->foreignIdFor(app('user'), 'creator_id')->nullable();
            $table->foreignIdFor(app('user'), 'updater_id')->nullable();
            $table->timestamps();

            $table->unique(['name', 'type']);
        });
    }
}
