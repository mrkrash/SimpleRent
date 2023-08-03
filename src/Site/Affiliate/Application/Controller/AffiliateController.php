<?php

namespace App\Site\Affiliate\Application\Controller;

use App\Site\Affiliate\Application\Form\AffiliateType;
use App\Site\Affiliate\Domain\Entity\Affiliate;
use App\Site\Affiliate\Infrastructure\Repository\AffiliateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/affiliate')]
class AffiliateController extends AbstractController
{
    #[Route('/', name: 'app_affiliate_index', methods: ['GET'])]
    public function index(AffiliateRepository $affiliateRepository): Response
    {
        return $this->render('affiliate/index.html.twig', [
            'affiliates' => $affiliateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affiliate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffiliateRepository $affiliateRepository): Response
    {
        $affiliate = new Affiliate();
        $form = $this->createForm(AffiliateType::class, $affiliate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affiliateRepository->save($affiliate, true);

            return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affiliate/new.html.twig', [
            'affiliate' => $affiliate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affiliate_show', methods: ['GET'])]
    public function show(Affiliate $affiliate): Response
    {
        return $this->render('affiliate/show.html.twig', [
            'affiliate' => $affiliate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affiliate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affiliate $affiliate, AffiliateRepository $affiliateRepository): Response
    {
        $form = $this->createForm(AffiliateType::class, $affiliate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affiliateRepository->save($affiliate, true);

            return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affiliate/edit.html.twig', [
            'affiliate' => $affiliate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affiliate_delete', methods: ['POST'])]
    public function delete(Request $request, Affiliate $affiliate, AffiliateRepository $affiliateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affiliate->getId(), $request->request->get('_token'))) {
            $affiliateRepository->remove($affiliate, true);
        }

        return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
    }
}
