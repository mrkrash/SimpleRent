<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Form\AccessoryType;
use App\Repository\AccessoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accessory')]
class AccessoryController extends AbstractController
{
    #[Route('/', name: 'app_accessory_index', methods: ['GET'])]
    public function index(AccessoryRepository $accessoryRepository): Response
    {
        return $this->render('accessory/index.html.twig', [
            'accessories' => $accessoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accessory_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AccessoryRepository $accessoryRepository): Response
    {
        $accessory = new Accessory();
        $form = $this->createForm(AccessoryType::class, $accessory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessoryRepository->save($accessory, true);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accessory/new.html.twig', [
            'accessory' => $accessory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accessory_show', methods: ['GET'])]
    public function show(Accessory $accessory): Response
    {
        return $this->render('accessory/show.html.twig', [
            'accessory' => $accessory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accessory_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Accessory $accessory, AccessoryRepository $accessoryRepository): Response
    {
        $form = $this->createForm(AccessoryType::class, $accessory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessoryRepository->save($accessory, true);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accessory/edit.html.twig', [
            'accessory' => $accessory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accessory_delete', methods: ['POST'])]
    public function delete(Request $request, Accessory $accessory, AccessoryRepository $accessoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accessory->getId(), $request->request->get('_token'))) {
            $accessoryRepository->remove($accessory, true);
        }

        return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
    }
}
