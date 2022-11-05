<?php

namespace App\Utils\Traits\MessageHandler;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;

trait MessageHandlerCallCommandTrait
{
    protected Application $application;

    /** @required */
    public function setNewApplication(KernelInterface $kernel): void
    {
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
    }

    protected function callCommand(string $commandName, array $args = [], array $options = []): void
    {
        $command = $this->application->find($commandName);
        $input = new ArrayInput(array_merge($args, $options));
        $output = new NullOutput();

        $command->run($input, $output);
    }
}
