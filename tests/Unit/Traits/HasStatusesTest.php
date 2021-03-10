<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Tests\Unit\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Statuses\Exceptions\UnknownStatusException;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\StatusRecord;
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

        $status = $model->getStatus();
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
        $model->setStatus('test status');

        $foundStatus = $model->getStatus();
        $this->assertNotNull($foundStatus);
        $this->assertEquals($status->id, $foundStatus->id);
    }

    /** @test */
    public function set_valid_status_by_type()
    {
        TestModel::createTable();

        Status::publishStatuses('type1', ['statusA', 'statusB']);
        Status::publishStatuses('type2', ['status1', 'status2']);

        $model = new TestModel();
        $model->save();

        $this->actingAs(User::factory()->create());
        $model->setStatus('statusA', 'type1');
        $model->setStatus('status1', 'type2');

        $foundStatus = $model->getStatus();
        $this->assertNull($foundStatus);

        $foundStatus = $model->getStatus('type1');
        $this->assertNotNull($foundStatus);
        $this->assertEquals('statusA', (string) $foundStatus);

        $foundStatus = $model->getStatus('type2');
        $this->assertNotNull($foundStatus);
        $this->assertEquals('status1', (string) $foundStatus);

        $model->setStatus('statusB', 'type1');
        $model->setStatus('status2', 'type2');

        $this->assertEquals('statusB', (string) $model->getStatus('type1'));
        $this->assertEquals('status2', (string) $model->getStatus('type2'));
    }

    public function get_status_history()
    {
        TestModel::createTable();

        Status::publishStatuses('type1', ['A', 'B', 'C', 'D']);
        Status::publishStatuses('type2', ['1', '2', '3', '4']);

        $model = new TestModel();
        $model->save();

        $this->actingAs(User::factory()->create());
        $model->setStatus('A', 'type1');
        $model->setStatus('D', 'type1');
        $model->setStatus('C', 'type1');
        $model->setStatus('A', 'type1');
        $model->setStatus('B', 'type1');
        $history = $model->getStatusHistory('type1')
            ->map(function (StatusRecord $statusRecord) {
                return (string) $statusRecord->status;
            })
            ->toArray();
        $this->assertEquals(['B','A','C','D','A'], $history);

        $model->setStatus('3', 'type2');
        $model->setStatus('3', 'type2');
        $model->setStatus('2', 'type2');
        $model->setStatus('2', 'type2');
        $model->setStatus('3', 'type2');
        $model->setStatus('3', 'type2');
        $model->setStatus('2', 'type2');
        $model->setStatus('2', 'type2');
        $history = $model->getStatusHistory('type2')
            ->map(function (StatusRecord $statusRecord) {
                return (string) $statusRecord->status;
            })
            ->toArray();
        $this->assertEquals(['2', '3', '2', '3'], $history);
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
        $model->setStatus('test status');
    }

    /** @test */
    public function set_unknown_status_dynamic_creation()
    {
        TestModel::createTable();

        $model = new TestModel();
        $model->save();
        $model->setDynamicStaticCreation(true);

        $this->actingAs(User::factory()->create());
        $status = $model->setStatus('test status');

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
