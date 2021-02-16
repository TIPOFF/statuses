<?php

namespace Tipoff\Statuses\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Status extends BaseResource
{
    public static $model = \Tipoff\Statuses\Models\Status::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $group = 'Operations Units';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Slug')->sortable(),
            Text::make('Name')->sortable(),
            Text::make('Applies To', 'applies_to')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Name')->required(),
            Slug::make('Slug')->from('Name'),
            Text::make('Applies To', 'applies_to'),
            Text::make('Note'),

            new Panel('Data Fields', $this->dataFields()),

        ]);
    }

    protected function dataFields(): array
    {
        return [
            ID::make(),
            DateTime::make('Created At')->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ];
    }
}
