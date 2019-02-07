<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ParseJsonUsers extends Command
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:parse-users';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Inserts JSON parsed items into database.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to parse JSON data from remote feed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $content=file_get_contents("https://gist.githubusercontent.com/emodus/27d245484a85c2286722b9d146c53354/raw/c9af224580a22cbde969127527c4500e3f7d2a9e/dummyFeed");
        $data=json_decode($content, true);



        foreach ($data['items'] as $row)
        {
            //var_dump($row);die;
            $user = new Users();
            $user->setIndex($row['index']);
            $user->setIndexStartAt($row['index_start_at']);
            $user->setSomeNumber($row['integer']);
            $user->setFloater($row['float']);
            $user->setFirstName($row['name']);
            $user->setSurname($row['surname']);
            $user->setFullname($row['fullname']);
            $user->setEmail($row['email']);
            $user->setBully($row['bool']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $this->entityManager->persist($user);

        }
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();

        echo "ALL DATA INSERTED";
    }
}