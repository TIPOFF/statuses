<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Statuses\Exceptions\UnknownStatusException;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\Statusable;
use Tipoff\Statuses\Tests\TestCase;
use Tipoff\Statuses\Traits\HasStatuses;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Models\TestModelStub;

class HasStatusesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function no_status_set()
    {
        TestModel::createTable();

        $model = new TestModel();
        $model->save();

        $status = $model->status();
        $this->assertNull($status);
    }

    /** @test */
    public function set_valid_status()
    {
        TestModel::createTable();

        $status = Status::createStatus(TestModel::class, 'test status');

        $model = new TestModel();
        $model->save();

        $this->actingAs(User::factory()->create());
        $model->status('test status');

        $foundStatus = $model->status();
        $this->assertNotNull($foundStatus);
        $this->assertEquals($status->id, $foundStatus->id);
    }

    /** @test */
    public function set_unknown_status()
    {
        TestModel::createTable();

        $model = new TestModel();
        $model->save();

        $this->expectException(UnknownStatusException::class);
        $this->expectExceptionMessage("Unknown status value 'test status' for status type Tipoff\Statuses\Tests\Unit\Traits\TestModel");

        $this->actingAs(User::factory()->create());
        $model->status('test status');
    }

    /** @test */
    public function set_unknown_status_dynamic_creation()
    {
        TestModel::createTable();

        $model = new TestModel();
        $model->save();
        $model->setDynamicStaticCreation(true);

        $this->actingAs(User::factory()->create());
        $status = $model->status('test status');

        $this->assertNotNull($status);
        $this->assertEquals('test status', (string) $status);
    }
}

class TestModel extends BaseModel
{
    use TestModelStub;
    use HasStatuses;

    public function setDynamicStaticCreation(bool $isDynamic): self
    {
        $this->dynamicStatusCreation = $isDynamic;

        return $this;
    }
}
