<?php

class StarterKitPostInstall
{
    public function handle($console)
    {
        $this->run(
            command: 'php artisan config:clear'
        );
    }
}
