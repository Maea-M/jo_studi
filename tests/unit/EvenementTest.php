<?php

namespace App\Tests;

use App\Entity\Evenement;

use PHPUnit\Framework\TestCase;

class EvenementUnitTest extends TestCase
{
    public function testIsValid(): void
    {
        /* entité avec id, date, location, place, imageFile, imageName, imageSize*/
        $evenement = new Evenement();
        $date = new \DateTimeImmutable();

        $evenement->setDate($date)
            ->setLocation('Paris')
            ->setPlace(50);


        $this->assertSame($date, $evenement->getDate());
        $this->assertSame('Paris', $evenement->getLocation());
        $this->assertSame(50, $evenement->getPlace());
    } 

}