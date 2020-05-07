<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use App\Entity\Comment;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AppFixtures extends Fixture
{
    private $encoders;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }



    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        $adminRole = new Role();

        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $coverImage = [
            "5e9c64280b800770531851.jpg",
            "5e874e9f08dce497280698.jpg",
            "5e8752f9bbf3e315524612.jpg",
            "5e8753fb0ef7d154849501.jpg",
            "5e8754a87651a631575390.jpg",
            "5e87527b41361472037364.jpg",
            "5e87538c20cb1621370172.jpg",
            "5e87539ede6b7425252155.jpg",
            "5e87544da8056745940176.jpg",
            "5e875411da04e721586654.jpg",
            "5e8753120e8ad854981769.jpg",
            "5e8754590ee9b890191550.jpg",
            "5e87546332fe4602826875.jpg",
            "5e87549635e6f244202064.jpg",
            "5e875406317ac071040650.jpg",
            "5e87537518067630800359.jpg"
        ];

        $adminUser = new User();
        $adminUser->setFirstName('Igali')
            ->setLastName('ILMI AMIR')
            ->setEmail('igali@gmail.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://randomuser.me/api/portraits/men/54.jpg')
            ->setIntroduction($faker->sentence())
            ->setDescription(('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>'))
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

        // Gestion des utilisateurs
        $users = [];
        $genres = ['male', 'female'];

        for ($z = 1; $z <= 10; $z++) {

            $user = new User();
            $genre = $faker->randomElement($genres);
            $picture = "https://randomuser.me/api/portraits/";
            $picture_id = $faker->numberBetween(1, 99) . '.jpg';

            //If
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $picture_id;

            // if ($genre == "male") {
            //     $picutre = $picture . 'men/' . $picture_id;
            // }else {
            //     $picutre = $picture . 'women/' . $picture_id;
            // }

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);
            $manager->persist($user);
            $users[] = $user;
        }

        $cities = [
            "Besançon",
            "Bordeaux",
            "Paris",
            "Lyon",
            "Nantes",
            "Reims",
            "Marseille",
            "Rennes",
            "Dijon",
            "Monaco"
        ];

        // Gestion des annonces
        for ($i = 1; $i <= 15; $i++) {

            $ad = new Ad();

            $title      = $faker->sentence();
            $slug       = $slugify->slugify($title);
            // $coverImageId = $faker->numberBetween(1, 85);
            // $coverImage = "https://i.picsum.photos/id/" . $coverImageId . "/800/800.jpg";
            $introduction = $faker->paragraph(2);
            $content    = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setSlug($slug)
                ->setIntroduction($introduction)
                ->setFilename($faker->unique()->randomElement($coverImage))
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user)
                ->setUpdatedAt($faker->dateTime('now', null))
                ->setCity($faker->randomElement($cities));

            for ($j = 0; $j < mt_rand(2, 5); $j++) {

                $image = new Image();

                $pictureId = $faker->numberBetween(1, 85);
                $picture = "https://i.picsum.photos/id/" . $pictureId . "/200/200.jpg";
                $image->setUrl($picture)
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            // Gestion des réservations

            for ($h = 1; $h <= mt_rand(0, 10); $h++) {

                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');

                // Gestion de la date de fin
                $duration  = mt_rand(3, 10);
                $endDate   = (clone $startDate)->modify("+$duration days");
                $amount    = $ad->getPrice() * $duration;

                // Attribution des utilisateurs
                $booker    = $users[mt_rand(0, count($users) - 1)];

                // Création du commentaire
                $comment   = $faker->paragraph();

                $booking->setBooker($booker)
                    ->setAd($ad)
                    ->setCreatedAt($createdAt)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setComment($comment)
                    ->setAmount($amount);

                $manager->persist($booking);

                // Gestion des commentaires
                if (mt_rand(0, 1)) {
                    $comment = new Comment();
                    $comment->setContent($faker->paragraph())
                        ->setRating(mt_rand(1, 5))
                        ->setAuthor($booker)
                        ->setAd($ad);
                    $manager->persist($comment);
                }
            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
