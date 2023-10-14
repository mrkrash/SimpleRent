<?php

namespace App\Site\Page\Application\Controller;

use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {
    }

    #[Route('/news/{slug}', name: 'news_page')]
    public function show(Page $news): Response
    {
        return $this->render('home/generic.html.twig', [
            'title' => $news->getTitle(),
            'content' => $news->getContent(),
            'slides' => $news->getSlides(),
            'date' => $news->getDate(),
        ]);
    }

    #[Route('/chi-siamo', name: 'who_are')]
    public function whoAre(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'who_are']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
            'slides' => $page->getSlides(),
        ]);
    }

    #[Route('/ragusa-ibla', name: 'ragusa_ibla')]
    public function ragusaIbla(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'ragusa_ibla']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
            'slides' => $page->getSlides(),
        ]);
    }

    #[Route('/terms', name: 'terms')]
    public function terms(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'terms']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/accept-privacy', name: 'accept_privacy')]
    public function acceptPrivacy(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'accept_privacy']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/privacy', name: 'privacy')]
    public function privacy(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'privacy']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/cookies_policy', name: 'cookies_policy')]
    public function cookie(): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->findOneBy(['slug' => 'cookie_policy']);
        if (!$page) {
            return $this->render('coming.html.twig');
        }
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }
}
