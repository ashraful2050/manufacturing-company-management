<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    protected function getOptions(): array
    {
        $options = parent::getOptions();
        foreach ($options as &$option) {
            if ($option[0] === 'port') {
                $option[4] = 8106;
            }
        }
        return $options;
    }
}
