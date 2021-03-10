<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\Statusable;
use Tipoff\Statuses\Tests\TestCase;

class StatusableTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Statusable::factory()->create();
        $this->assertNotNull($model);

        $status = $model->status;
        $this->assertInstanceOf(Status::class, $status);

        $statusable = $model->statusable;
        $this->assertInstanceOf(Model::class, $statusable);
    }
}
