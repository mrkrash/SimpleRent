<?php

namespace App\Booking\Application\Controller;

use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/landing', name: 'payment_landing')]
    public function landing(): Response
    {
        return $this->render('rent/success.html.twig');
    }

    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('rent/error.html.twig');
    }
}
