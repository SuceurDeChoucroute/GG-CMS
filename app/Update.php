<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Update
{
    public function production(Runner $run)
    {
        return $run
            ->external('sudo', 'git', 'pull')
            ->external('sudo', 'composer', 'install', '--no-dev')
            ->artisan('migrate', ['--force' => true])
            ->external('npm', 'install', '--production')
            ->external('sudo', 'npm', 'run', 'production')
            ->artisan('cache:clear');
    }

    public function local(Runner $run)
    {
        return $run
            ->external('sudo', 'git', 'pull')
            ->external('sudo', 'composer', 'install')
            ->artisan('migrate')
            ->external('npm', 'install')
            ->external('sudo', 'npm', 'run', 'development')
            ->artisan('cache:clear');
    }
}
