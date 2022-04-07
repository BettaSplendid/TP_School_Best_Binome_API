<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        var_dump('Loading data fixtures');
        $faker = Faker\Factory::create();
        $Json = file_get_contents("src/DataFixtures/people2.json");
        $myarray = json_decode($Json, true);
        // var_dump($myarray);


        var_dump("Generating Sections: ");
        $cp = new Section();
        $cp->setName("CP");
        $manager->persist($cp);

        $ce1 = new Section();
        $ce1->setName("CE1");
        $manager->persist($ce1);

        $ce2 = new Section();
        $ce2->setName("CE2");
        $manager->persist($ce2);

        $cm1 = new Section();
        $cm1->setName("CM1");
        $manager->persist($cm1);

        $cm2 = new Section();
        $cm2->setName("CM2");
        $manager->persist($cm2);
        $manager->flush();



        var_dump("Generating Students: ");

        //faux etudiant pour connexion 
        $special_student = (new Student())->setFirstName("Amelie")->setName("KLEIN")->setUsername("ak54")
            ->setEmail("ak@gmail.com")->setGender(0)->setPassword("123")->setSection($manager->getRepository(Section::class)->findBy(['Name' => 'CP'])[0]);
        $special_student->setParentEmail1("22@gmaikl.fr");
        $manager->persist($special_student);

        $studentb = (new Student())->setFirstName("Amelie")->setName("KLEIN")->setUsername("ak542")->setEmail("ak2@gmail.com")->setGender(0)->setPassword("123");
        $studentb->setParentEmail1("22@gmaikl.fr");
        $manager->persist($studentb);

        foreach ($myarray["CP"] as $key => $value) {
            // var_dump($myarray["CP"][$key0]);
            $pieces = explode(" ", $myarray["CP"][$key]);
            $student = new Student();
            $student->setFirstName($pieces[0]);
            $student->setName($pieces[1]);
            $student->setUsername($student->getName() . $student->getFirstName() . "du" . rand(0, 100));
            $student->setEmail(($student->getUsername() . rand() . "@" . $faker->freeEmailDomain));
            $student->setParentEmail1(($student->getName() . $faker->firstName . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
            $student->setParentEmail2(($student->getName() . $faker->firstName . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
            $student->setGender((bool) mt_rand(0, 1));
            $student->setPassword(rand());
            $result = $manager->getRepository(Section::class)->findOneBy(['Name' => "CP"]);
            $student->setSection($manager->getRepository(Section::class)->findOneBy(['Name' => 'CP']));
            // $student->setSection($manager->getRepository(Section::class)->findBy(['Name' => $all_profs[$key]->section])[0]);

            $manager->persist($student);
            $manager->flush();
        }

        Var_dump("Generating Professors: ");

        $prof_cp = (object) ['name' => 'Delenoix', 'firstname' => 'Jean', 'section' => 'CP'];
        $prof_ce1 = (object) ['name' => 'Bekritch', 'firstname' => 'Justine', 'section' => 'CE1'];
        $prof_ce2 = (object) ['name' => 'Garbo', 'firstname' => 'Greta', 'section' => 'CE2'];
        $prof_cm1 = (object) ['name' => 'Ghelain', 'firstname' => 'Georges', 'section' => 'CM1'];
        $prof_cm2 = (object) ['name' => 'Charbonnier', 'firstname' => 'Gisèle', 'section' => 'CM2'];

        $all_profs = array($prof_cp, $prof_ce1, $prof_ce2, $prof_cm1, $prof_cm2);
        // var_dump($all_profs);
        foreach ($all_profs as $key => $value) {
            // var_dump($all_profs[$key]);
            $prof = new Professor();
            $prof->setName($all_profs[$key]->name);
            $prof->setFirstName($all_profs[$key]->firstname);
            $prof->setSection($manager->getRepository(Section::class)->findBy(['Name' => $all_profs[$key]->section])[0]);
            $prof->setPassword(rand());

            $prof->SetEmail($prof->getName() . $prof->getFirstName() . "@" . $faker->freeEmailDomain);
            $prof->setUsername($prof->getName() . $prof->getFirstName() . "teach");
            $prof->setAge(rand(18, 60));
            $prof->setArrivalDate(new \DateTime());
            $prof->setSalary(rand(1000, 2300));
            $manager->persist($prof);
        }


        $manager->flush();
    }

}