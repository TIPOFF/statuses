<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Commands;

use Illuminate\Console\Command;

class StatusesCommand extends Command
{
    public $signature = 'statuses';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
