<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('status_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('status'))->index();
            $table->morphs('statusable');
            $table->string('type');     // Typically, full class name for model using status
            $table->foreignIdFor(app('user'), 'creator_id')->nullable();
            $table->timestamp('created_at');
        });
    }
}
