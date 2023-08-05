<?php

namespace App\Site\Page\Application\Controller;

use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    #[Route('/ragusa-ibla', name: 'ragusa_ibla')]
    public function ragusaIbla(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'ragusa-ibla']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
            'slides' => $page->getSlides(),
        ]);
    }
}