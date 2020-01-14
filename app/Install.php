<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Install
{
    public function production(Runner $run)
    {
        return $run
            ->external('sudo', 'composer', 'install', '--no-dev')
            ->artisan('key:generate', ['--force' => true])
            ->artisan('migrate', ['--force' => true])
            ->artisan('storage:link')
            ->external('npm', 'install', '--production')
            ->external('sudo', 'npm', 'run', 'production');
    }

    public function local(Runner $run)
    {
        return $run
            ->external('composer', 'install')
            ->artisan('key:generate')
            ->artisan('migrate')
            ->artisan('storage:link')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development');
    }
}
