<?php

namespace App\Product\Application\Controller;

use App\Product\Application\Form\AccessoryFormType;
use App\Product\Domain\Entity\Accessory;
use App\Product\Domain\Entity\AccessoryQty;
use App\Product\Infrastructure\Repository\AccessoryQtyRepository;
use App\Product\Infrastructure\Repository\AccessoryRepository;
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
    #[Route('/', name: 'app_accessory_index', methods: ['GET'])]
    public function index(AccessoryRepository $accessoryRepository): Response
    {
        return $this->render('accessory/index.html.twig', [
            'accessories' => $accessoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accessory_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AccessoryRepository $accessoryRepository,
        AccessoryQtyRepository $accessoryQtyRepository,
        string $uploadDir
    ): Response {
        $accessory = new Accessory();
        $form = $this->createForm(AccessoryFormType::class, $accessory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessoryQty = (new AccessoryQty())
                ->setSizeXs($form['sizeXS']->getData())
                ->setSizeS($form['sizeS']->getData())
                ->setSizeM($form['sizeM']->getData())
                ->setSizeL($form['sizeL']->getData())
                ->setSizeXl($form['sizeXL']->getData())
                ->setSize36($form['size36']->getData())
                ->setSize37($form['size37']->getData())
                ->setSize38($form['size38']->getData())
                ->setSize39($form['size39']->getData())
                ->setSize40($form['size40']->getData())
                ->setSize41($form['size41']->getData())
                ->setSize42($form['size42']->getData())
                ->setSize43($form['size43']->getData())
                ->setSize44($form['size44']->getData())
                ->setSize45($form['size45']->getData())
                ->setSize45($form['size45']->getData())
                ->setSize47($form['size47']->getData())
                ->setAccessory($accessory)
            ;
            $accessory->setImage($this->saveImage($form, $uploadDir));
            $accessoryRepository->save($accessory, true);
            $accessoryQtyRepository->save($accessoryQty, true);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessory/new.html.twig', [
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
    public function edit(
        Request $request,
        Accessory $accessory,
        AccessoryRepository $accessoryRepository,
        string $uploadDir
    ): Response {
        $accessory->populateQty();
        $form = $this->createForm(AccessoryFormType::class, $accessory, [
            'require_main_image' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessoryQty = $accessory->getAccessoryQty()
                ->setSizeXs($form['sizeXS']->getData())
                ->setSizeS($form['sizeS']->getData())
                ->setSizeM($form['sizeM']->getData())
                ->setSizeL($form['sizeL']->getData())
                ->setSizeXl($form['sizeXL']->getData())
                ->setSize36($form['size36']->getData())
                ->setSize37($form['size37']->getData())
                ->setSize38($form['size38']->getData())
                ->setSize39($form['size39']->getData())
                ->setSize40($form['size40']->getData())
                ->setSize41($form['size41']->getData())
                ->setSize42($form['size42']->getData())
                ->setSize43($form['size43']->getData())
                ->setSize44($form['size44']->getData())
                ->setSize45($form['size45']->getData())
                ->setSize45($form['size45']->getData())
                ->setSize47($form['size47']->getData())
                ->setAccessory($accessory)
            ;
            $accessory->setAccessoryQty($accessoryQty);
            $filename = $this->saveImage($form, $uploadDir);
            if (null !== $filename) {
                $accessory->setImage($filename);
            }
            $accessoryRepository->save($accessory, true);

            return $this->redirectToRoute('app_accessory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessory/edit.html.twig', [
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
