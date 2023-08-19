<?php

namespace App\Product\Application\Controller;

use App\Product\Application\Form\AccessoryFormType;
use App\Product\Application\Service\PriceListService;
use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Accessory;
use App\Product\Domain\Entity\AccessoryQty;
use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\AccessoryQtyRepository;
use App\Product\Infrastructure\Repository\AccessoryRepository;
use App\Shared\Enum\ProductType;
use App\Shared\Service\FileUploader;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/accessory')]
class AccessoryController extends AbstractController
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly PriceListService $listService,
        private readonly ProductService $productService,
    ) {
    }

    #[Route('/', name: 'app_accessory_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('accessory/index.html.twig', [
            'accessories' => $this->productService->retrieveByType(ProductType::ACCESSORY)
        ]);
    }

    #[Route('/new', name: 'app_accessory_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
    ): Response {
        $accessory = new Product();
        $accessory->setType(ProductType::ACCESSORY);
        $form = $this->createForm(AccessoryFormType::class, $accessory, [
            'priceList_choices' => $this->listService->findAll(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessory = $this->productService->handleQty($accessory, $form);
            $accessory->setImage($this->fileUploader->upload($form['uploadImage']->getData()));
            $this->productService->persist($accessory);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessory/new.html.twig', [
            'accessory' => $accessory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accessory_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Product $accessory,
    ): Response {
        $form = $this->createForm(AccessoryFormType::class, $accessory, [
            'priceList_choices' => $this->listService->findAll(),
            'require_main_image' => false,
            'qty' => $this->productService->retrieveQty($accessory),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessory = $this->productService->handleQty($accessory, $form);
            /** @var ?UploadedFile $image */
            $image = $form['uploadImage']->getData();
            if ($image) {
                $accessory->setImage($this->fileUploader->upload($image));
            }
            $this->productService->persist($accessory);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessory/edit.html.twig', [
            'accessory' => $accessory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accessory_delete', methods: ['POST'])]
    public function delete(Request $request, Product $accessory): Response
    {
        if ($this->isCsrfTokenValid('delete' . $accessory->getId(), $request->request->get('_token'))) {
            $this->productService->remove($accessory);
        }

        return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
    }
}
