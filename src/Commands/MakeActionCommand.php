<?php

namespace Glen Bangkila\MakeAction\Commands;

use Illuminate\Console\Command;

class MakeActionCommand extends Command
{
    public $signature = 'make-action';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
