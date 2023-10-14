<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'user:create',
    description: 'Creates a new user.'
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user')
            ->addArgument('username', InputArgument::REQUIRED, 'The username to use.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password to use.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $output->writeln([
            'User Creation',
            '=============',
            '',
            'Username: ' . $username,
        ]);

        $user = (new User())->setUsername($username)->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $this->userRepository->save($user, true);

        $output->writeln('User successfully generated!');

        return Command::SUCCESS;
    }
}
