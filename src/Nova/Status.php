<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Statuses\Enum\StatusType;
use Tipoff\Support\Nova\BaseResource;

class Status extends BaseResource
{
    public static $model = \Tipoff\Statuses\Models\Status::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public static $group = 'Z - Admin';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Slug')->sortable(),
            Text::make('Name')->sortable(),
            Text::make('Type', 'type')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Name')->rules(['required']),
            Slug::make('Slug')->from('Name')->rules(['required']),
            Select::make('Type')->options([
                StatusType::BOOKING => 'Booking',
                StatusType::CONTACT => 'Order',
                StatusType::ORDER => 'Contact',
            ])
                ->rules(['required'])
                ->sortable()->displayUsingLabels(),
            Text::make('Note'),

            new Panel('Data Fields', $this->dataFields()),

        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields(),
        );
    }
}
