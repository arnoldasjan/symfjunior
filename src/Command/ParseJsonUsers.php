<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseJsonUsers extends Command
{
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

        $connect = pg_connect("host=localhost port=5432 dbname=db_name user=postgres password=db_password");

        foreach ($data['items'] as $row)
        {
            $sql = "INSERT INTO users(index, index_start_at, some_number, floater,
                  first_name, surname, fullname, email, bully) VALUES ('".$row["index"]."','".$row["index_start_at"]."', '".$row["integer"]."',
                  '".$row["float"]."'',''".$row["name"]."','".$row["surname"]."','".$row["fullname"]."',
                  '".$row["email"]."','".$row["bool"]."') ";

            pg_query($connect, $sql);
        }

        echo "ALL DATA INSERTED";
    }
}