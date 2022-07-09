<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function indexAction():Response
    {
        return
            $this->render('base.html.twig');
    }
}