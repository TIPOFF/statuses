<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Models;

use Assert\Assert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tipoff\Discounts\Models\Discount;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

/**
 * @property int id
 * @property string name
 * @property string type
 * @property string slug
 * @property string note
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Status extends BaseModel
{
    use HasPackageFactory;

    protected $casts = [
        'id' => 'integer',
    ];

    protected $fillable = [
        'type',
        'name',
    ];

    public static function publishStatuses(string $type, array $names): Collection
    {
        return collect($names)
            ->map(function (string $name) use ($type) {
                return static::createStatus($type, $name);
            });
    }

    public static function createStatus(string $type, string $name, ?string $note = null): self
    {
        /** @var Status $status */
        $status = static::query()->firstOrNew([
            'type' => $type,
            'name' => $name
        ]);

        if ($note) {
            $status->note = $note;
        }

        $status->save();

        return $status;
    }

    public static function findStatus(string $type, string $name): ?self
    {
        /** @var Status $status */
        $status = static::query()
            ->byType($type)
            ->where('name', '=', $name)
            ->first();

        return $status;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Status $status) {
            $status->slug = $status->slug ?: Str::slug("{$status->type}-{$status->name}");
        });
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', '=', $type);
    }

    public function __toString()
    {
        return $this->name;
    }
}
