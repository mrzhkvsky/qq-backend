<?php
declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Enum\GenderEnum;
use App\Domain\User\Service\UserService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);


        $email = $helper->ask($input, $output, new Question('Email:' . PHP_EOL));
        $firstName = $helper->ask($input, $output, new Question('First name:' . PHP_EOL));
        $lastName = $helper->ask($input, $output, new Question('Last name:' .PHP_EOL));
        $password = $helper->ask($input, $output, new Question('Password:' . PHP_EOL));
        $gender = $helper->ask($input, $output, new ChoiceQuestion('Gender:' . PHP_EOL, array_values(GenderEnum::values())));

        $this->userService->createUser(new CreateUserData(
            $email,
            $firstName,
            $lastName,
            $password,
            new GenderEnum($gender)
        ));

        $output->writeln('User successfully generated!');

        return Command::SUCCESS;
    }
}
