<?php

namespace App\Site\Page\Application\Controller;

use App\Shared\Service\FileUploader;
use App\Site\Page\Application\Form\NewsFormType;
use App\Site\Page\Application\Form\PageFormType;
use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Domain\Entity\Slide;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

abstract class AdminControllerAbstract extends AbstractController
{
    protected function handleForm(
        Request $request,
        FileUploader $fileUploader,
        PageRepository $pageRepository,
        Page $page
    ): array {
        if ($page->getType() === Page::STANDARD) {
            $form = $this->createForm(PageFormType::class, $page);
        } else {
            $form = $this->createForm(NewsFormType::class, $page);
        }

        $form->handleRequest($request);
        $result = false;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ?UploadedFile[] $slides */
            $slides = $form['uploadSlides']->getData();
            if (!empty($slides)) {
                foreach ($slides as $slide) {
                    $page->addSlide((new Slide())->setName($fileUploader->upload($slide))->setPage($page));
                }
            }
            $pageRepository->save($page, true);

            $result = true;
        }

        return [$form, $result];
    }
}
