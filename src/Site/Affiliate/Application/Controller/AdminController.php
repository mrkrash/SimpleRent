<?php

namespace App\Site\Affiliate\Application\Controller;

use App\Shared\Service\FileUploader;
use App\Site\Affiliate\Application\Form\AffiliateType;
use App\Site\Affiliate\Domain\Entity\Affiliate;
use App\Site\Affiliate\Infrastructure\Repository\AffiliateRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/affiliate')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_affiliate_index', methods: ['GET'])]
    public function index(AffiliateRepository $affiliateRepository): Response
    {
        return $this->render('affiliate/index.html.twig', [
            'affiliates' => $affiliateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affiliate_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AffiliateRepository $affiliateRepository,
        FileUploader $fileUploader,
    ): Response {
        $affiliate = new Affiliate();
        $form = $this->createForm(AffiliateType::class, $affiliate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ?UploadedFile $image */
            $image = $form['uploadImage']->getData();
            if ($image) {
                $affiliate->setImage($fileUploader->upload($image));
            }
            $affiliateRepository->save($affiliate, true);

            return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('affiliate/new.html.twig', [
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

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_affiliate_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Affiliate $affiliate,
        AffiliateRepository $affiliateRepository,
        FileUploader $fileUploader,
    ): Response {
        $form = $this->createForm(AffiliateType::class, $affiliate, [
            'require_main_image' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ?UploadedFile $image */
            $image = $form['uploadImage']->getData();
            if ($image) {
                $affiliate->setImage($fileUploader->upload($image));
            }
            $affiliateRepository->save($affiliate, true);

            return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('affiliate/edit.html.twig', [
            'affiliate' => $affiliate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affiliate_delete', methods: ['POST'])]
    public function delete(Request $request, Affiliate $affiliate, AffiliateRepository $affiliateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $affiliate->getId(), $request->request->get('_token'))) {
            $affiliateRepository->remove($affiliate, true);
        }

        return $this->redirectToRoute('app_affiliate_index', [], Response::HTTP_SEE_OTHER);
    }
}
