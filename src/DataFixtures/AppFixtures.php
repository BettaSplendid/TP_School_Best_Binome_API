<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create();

        $Json = file_get_contents("testjson.json");
        // Converts to an array 
        $myarray = json_decode($Json, true);

        var_dump($myarray);

        // $json_file = 'people.json';
        // settype($json_file, 'object');
        // json_decode($json_file);
        // $json_count = count($json_file);

        // foreach ($variable as $key => $value) {
        //     # code...
        // }

        $student = new Student();
        // $pieces = explode(" ", $json_file);
        // $student->setName($pieces[0]);
        // $student->setFirstName($pieces[1]);7

        $student->setName($faker->name);
        $student->setFirstName(($faker->firstName));

        $student->setEmail(($faker->email));
        $student->setUsername(($faker->userName));
        $student->setParentEmail1(($faker->email));

        $student->setParentEmail2(($faker->email));


        $student->setGender((bool) mt_rand(0, 1));

        $student->setPassword(rand());
        // $student->setFirstName($pieces[1]);
        // $student->setFirstName($pieces[1]);


        $manager->persist($student);
        $manager->flush();


        // json_encode()




    }
}