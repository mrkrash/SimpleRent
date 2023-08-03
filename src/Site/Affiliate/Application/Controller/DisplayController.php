<?php

namespace App\Site\Affiliate\Application\Controller;

use App\Site\Affiliate\Infrastructure\Repository\AffiliateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    #[Route('/strutture-convenzionate', name: 'where_to_stay')]
    public function whereToStay(AffiliateRepository $affiliateRepository): Response
    {
        return $this->render('home/where_stay.html.twig', [
            'affiliates' => $affiliateRepository->findAll()
        ]);
    }
}
