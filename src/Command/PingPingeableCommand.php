<?php

namespace App\Command;

use App\Entity\PingeableInterface;
use App\Pinger\Pinger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PingPingeableCommand extends Command
{
    public const NAME = 'app:ping:pingeable';
    public const ARG_CLASSNAME = 'classname';
    public const ARG_ID = 'id';

    public function __construct(private readonly Pinger $pinger, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct(self::NAME);
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::ARG_CLASSNAME, InputArgument::REQUIRED, 'Le nom de la classe du pingeable')
            ->addArgument(self::ARG_ID, InputArgument::REQUIRED, 'L\'id du pingeable')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $classname = $input->getArgument(self::ARG_CLASSNAME);

        if (!is_string($classname) || !class_exists($classname)) {
            throw new \LogicException(sprintf('L\'argument %s doit être renseigné avec le classname d\'une entité', self::ARG_CLASSNAME));
        }

        $id = $input->getArgument(self::ARG_ID);

        if (!is_numeric($id)) {
            throw new \LogicException(sprintf('L\'argument %s doit être renseigné avec un id d\'une entité', self::ARG_ID));
        }

        $pingeable = $this->entityManager->find($classname, $id);

        if (!$pingeable instanceof PingeableInterface) {
            throw new \LogicException('Impossible de ping une entité n\'implémentant pas l\'interface '.PingeableInterface::class);
        }

        $this->pinger->ping($pingeable);

        return 0;
    }
}
