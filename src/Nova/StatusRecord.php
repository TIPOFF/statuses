<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class StatusRecord extends BaseResource
{
    public static $model = \Tipoff\Statuses\Models\StatusRecord::class;

    public static $title = 'id';

    public static $search = [
        'id', 'type',
    ];

    public static $group = 'Z - Admin';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Type', )->sortable(),
            Text::make('Status', 'status.id', function () {
                return $this->status->name;
            })->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Type'),
            nova('status') ? BelongsTo::make('Status', 'status', nova('status'))->searchable() : null,
            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return [
            ID::make(),
            DateTime::make('Created At')->exceptOnForms(),
            nova('user') ? BelongsTo::make('Creator', 'creator', nova('user'))->exceptOnForms() : null,
        ];
    }
}
