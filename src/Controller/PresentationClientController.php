<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PresentationClientController extends AbstractController
{
    #[Route('/presentation/client', name: 'app_presentation_client')]
    public function index(): Response
    {
        $studio = [
            'name' => 'Afaris Music Studio',
            'age' => 6,
            'totalPrograms' => 4
        ];

        return $this->render('presentation_client/index.html.twig',[
            'studio' => $studio
        ]);
    }
}
