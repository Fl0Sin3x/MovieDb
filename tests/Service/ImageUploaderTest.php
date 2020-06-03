<?php

namespace App\Tests\Service;

use App\Service\ImageUploader;
use PHPUnit\Framework\TestCase;

class ImageUploaderTest extends TestCase
{
    public function testGetRandomFileName()
    {
        // Pour tester les valeurs retournées par getRandomFileName() on instancie ImageUploader
        $imageUploader = new ImageUploader();

        // Puis on teste que la valeur de retour de la méthode correspond a nos critères

        $randomFileName = $imageUploader->getRandomFileName('jpg');
        // ex : 4Wx3TRLGU6w3.jpg
        // On vérifie que le type est bien un string
        $this->assertIsString($randomFileName);
        // On vérifie que la longueur est bien de 16 caractères
        // il n'existe pas d'assert qui regarde la longueur d'un string
        // mais il est possible de calculer la longueur et la comparer à un autre entier
        $this->assertEquals(16, strlen($randomFileName));

        // On vérifie que $randomFileName se termine par .jpg
        $this->assertStringEndsWith('.jpg', $randomFileName);
    }
}
