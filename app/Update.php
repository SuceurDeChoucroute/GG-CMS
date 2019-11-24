<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Update
{
    public function production(Runner $run)
    {
        return $run
            ->external('git', 'pull')
            ->external('composer', 'install', '--no-dev')
            ->artisan('migrate', ['--force' => true])
            ->external('npm', 'install', '--production')
            ->external('npm', 'run', 'production')
            ->artisan('cache:clear');
    }

    public function local(Runner $run)
    {
        return $run
            ->external('git', 'pull')
            ->external('composer', 'install')
            ->artisan('migrate')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development')
            ->artisan('cache:clear');
    }
}
