<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Users;
use App\Entity\Comment;

class CommentsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function buildFixtures(Users $appUser) : Users
    {
        $comments = [];
        $count = rand(25, 75);
        for ($i = 0; $i <= $count; $i++) {
            $comment = new Comment();
            $rand = $this->getRandomWord();
            $comment->setComment($rand);
            $comment->setAppUser($appUser);
            $appUser->addComment($comment);
        }
        return $appUser;
    }

    private function getRandomWord(int $len = 20)  : string
    {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 2, $len);
    }


}