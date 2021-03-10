<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Tests\TestCase;

class StatusTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Status::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test  */
    public function create_status()
    {
        $status = Status::createStatus('type', 'name', 'my note');
        $this->assertEquals('type-name', $status->slug);
        $this->assertEquals('type', $status->type);
        $this->assertEquals('name', $status->name);
        $this->assertEquals('my note', $status->note);
        $this->assertEquals('name', (string) $status);

        // Add same status again
        $status = Status::createStatus('type', 'name');
        $this->assertEquals('type-name', $status->slug);
        $this->assertEquals('my note', $status->note);
    }

    /** @test  */
    public function find_status()
    {
        $status = Status::findStatus('type', 'name');
        $this->assertNull($status);

        Status::createStatus('type', 'name');

        $status = Status::findStatus('type', 'name');
        $this->assertEquals('type-name', $status->slug);
        $this->assertEquals('type', $status->type);
        $this->assertEquals('name', $status->name);
        $this->assertEquals('name', (string) $status);

        $status = Status::findStatus('other-type', 'name');
        $this->assertNull($status);
    }

    /** @test  */
    public function publish_statuses()
    {
        $statuses = Status::publishStatuses('type', ['a', 'b', 'c']);
        $this->assertCount(3, $statuses);

        $status = Status::findStatus('type', 'a');
        $this->assertNotNull($status);

        $status = Status::findStatus('type', 'b');
        $this->assertNotNull($status);

        $status = Status::findStatus('type', 'c');
        $this->assertNotNull($status);
    }

    /** @test  */
    public function scope_by_type()
    {
        $statuses = Status::query()->byType('type')->get();
        $this->assertCount(0, $statuses);

        Status::publishStatuses('type', ['a', 'b', 'c']);

        $statuses = Status::query()->byType('type')->get();
        $this->assertCount(3, $statuses);
    }
}
