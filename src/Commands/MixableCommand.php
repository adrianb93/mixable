<?php

namespace AdrianBrown\Mixable\Commands;

use Illuminate\Console\Command;

class MixableCommand extends Command
{
    public $signature = 'mixable';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
