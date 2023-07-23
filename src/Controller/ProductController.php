<?php

namespace App\Controller;

use App\Form\ProductFormType;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Product\Infrastructure\Repository\ProductQtyRepository;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Repository\PriceListRepository;
use App\Shared\Enum\ProductType;
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
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ProductRepository $productRepository,
        ProductQtyRepository $productQtyRepository,
        PriceListRepository $priceListRepository,
        string $uploadDir
    ): Response {
        $product = new Product();
        $product->setType(ProductType::BYCICLE);
        $form = $this->createForm(ProductFormType::class, $product, [
            'priceList_choices' => $priceListRepository->findAll(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productQty = (new ProductQty())
                ->setSizeXs($form['sizeXS']->getData())
                ->setSizeS($form['sizeS']->getData())
                ->setSizeM($form['sizeM']->getData())
                ->setSizeL($form['sizeL']->getData())
                ->setSizeXl($form['sizeXL']->getData())
                ->setProduct($product)
            ;
            $product->setImage($this->saveImage($form, $uploadDir));
            $productRepository->save($product, true);
            $productQtyRepository->save($productQty, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Product $product,
        ProductRepository $productRepository,
        PriceListRepository $priceListRepository,
        string $uploadDir
    ): Response {
        $product->populateQty();
        $product->setType(ProductType::BYCICLE);
        $form = $this->createForm(ProductFormType::class, $product, [
            'priceList_choices' => $priceListRepository->findAll(),
            'require_main_image' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productQty = $product->getProductQty()
                ->setSizeXs($form['sizeXS']->getData())
                ->setSizeS($form['sizeS']->getData())
                ->setSizeM($form['sizeM']->getData())
                ->setSizeL($form['sizeL']->getData())
                ->setSizeXl($form['sizeXL']->getData())
                ->setProduct($product)
            ;
            $product->setProductQty($productQty);
            $filename = $this->saveImage($form, $uploadDir);
            if (null !== $filename) {
                $product->setImage($filename);
            }
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @throws Exception
     */
    private function saveImage(FormInterface $form, string $uploadDir): ?string
    {
        $filename = null;
        /** @var UploadedFile $file */
        $file = $form['uploadImage']->getData();
        if ($file) {
            $filename = bin2hex(random_bytes(6)) . '.' . $file->guessExtension();
            $file->move($uploadDir, $filename);
        }

        return $filename;
    }
}
