<?php

use Symfony\Component\Process\Process;
use function Laravel\Prompts\confirm;
class StarterKitPostInstall
{
    public function handle($console)
    {
        $console->call('optimize:clear');

        $this->installNpmDependencies($console);
    }

    protected function installNpmDependencies($console)
    {

        if (! confirm('Do you want to install NPM dependencies?')) {
            return;
        }

        $this->runShellCommand('npm install', $console);
    }

    private function runShellCommand($command, $console)
    {
        $console->info("Running: {$command}");

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300); // 5 minutes timeout

        $process->run(function ($type, $buffer) use ($console) {
            $console->info($buffer);
        });

        if (!$process->isSuccessful()) {
            $console->error("Command failed: {$command}");
            $console->error($process->getErrorOutput());
        }
    }
}
