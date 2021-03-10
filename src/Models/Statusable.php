<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tipoff\Authorization\Models\User;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;

/**
 * @property int id
 * @property Status status
 * @property Model statusable
 * @property User creator
 * @property Carbon created_at
 * @property Carbon updated_at
 * // Raw Relations
 * @property int|null creator_id
 */
class Statusable extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;

    protected $casts = [
        'id' => 'integer',
        'creator_id' => 'integer',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function statusable()
    {
        return $this->morphTo();
    }
}
