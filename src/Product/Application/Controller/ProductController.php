<?php

namespace App\Product\Application\Controller;

use App\Product\Application\Form\ProductFormType;
use App\Product\Application\Service\PriceListService;
use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Shared\Enum\ProductSize;
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
#[Route('/product')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly PriceListService $listService,
        private readonly ProductService $productService,
    ) {
    }

    #[Route('/', name: 'app_bicycle_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $this->productService->retrieveByType(ProductType::BYCICLE)
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
    ): Response {
        $product = new Product();
        $product->setType(ProductType::BYCICLE);
        $form = $this->createForm(ProductFormType::class, $product, [
            'priceList_choices' => $this->listService->findAll(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setImage($this->fileUploader->upload($form['uploadImage']->getData()));
            $this->productService->persist($product);
            $product = $this->productService->handleQty($product, $form);
            $this->productService->persist($product);

            return $this->redirectToRoute('app_bicycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Product $product,
    ): Response {
        $form = $this->createForm(ProductFormType::class, $product, [
            'priceList_choices' => $this->listService->findAll(),
            'require_main_image' => false,
            'qty' => $this->productService->retrieveQty($product),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $this->productService->handleQty($product, $form);

            /** @var ?UploadedFile $image */
            $image = $form['uploadImage']->getData();
            if ($image) {
                $product->setImage($this->fileUploader->upload($image));
            }
            $this->productService->persist($product);

            return $this->redirectToRoute('app_bicycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $this->productService->remove($product);
        }

        return $this->redirectToRoute('app_bicycle_index', [], Response::HTTP_SEE_OTHER);
    }
}
