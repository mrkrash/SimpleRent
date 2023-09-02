<?php

namespace App\Site\Page\Application\Controller;

use App\Shared\Service\FileUploader;
use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Domain\Entity\Slide;
use App\Site\Page\Domain\Repository\SlideRepositoryInterface;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/news')]
class AdminNewsController extends AdminControllerAbstract
{
    #[Route('/', name: 'app_news_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $pageRepository->findBy(['type' => Page::NEWS]),
        ]);
    }

    #[Route('/new', name: 'app_news_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        PageRepository $pageRepository,
        FileUploader $fileUploader,
    ): Response {
        $page = new Page();
        $page->setType(Page::NEWS);
        [ $form, $result ] = $this->handleForm(
            request: $request,
            fileUploader: $fileUploader,
            pageRepository: $pageRepository,
            page: $page
        );

        if ($result) {
            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/new.html.twig', [
            'news' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_show', methods: ['GET'])]
    public function show(Page $page): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $page,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_news_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Page $page,
        PageRepository $pageRepository,
        FileUploader $fileUploader,
    ): Response {
        [ $form, $result ] = $this->handleForm(
            request: $request,
            fileUploader: $fileUploader,
            pageRepository: $pageRepository,
            page: $page
        );

        if ($result) {
            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/edit.html.twig', [
            'news' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $page->getId(), $request->request->get('_token'))) {
            $pageRepository->remove($page, true);
        }

        return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/slide/drop/{id}')]
    public function dropSlide(Slide $slide, SlideRepositoryInterface $slideRepository): JsonResponse
    {
        $slideRepository->remove($slide, true);

        return new JsonResponse(['success' => true]);
    }
}
