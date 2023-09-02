<?php

namespace App\Site\News\Application\Controller;

use App\Shared\Service\FileUploader;
use App\Site\News\Application\Form\NewsFormType;
use App\Site\News\Application\Service\NewsService;
use App\Site\News\Domain\Entity\News;
use App\Site\Shared\Domain\Entity\Slide;
use App\Site\Shared\Domain\Repository\SlideRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/news')]
class AdminController extends AbstractController
{
    public function __construct(
        private readonly NewsService $service
    ) {
    }

    #[Route('/', name: 'app_news_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $this->service->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_news_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        FileUploader $fileUploader,
    ): Response {
        $news = new News();
        [ $form, $result ] = $this->handleForm(
            request: $request,
            fileUploader: $fileUploader,
            news: $news
        );

        if ($result) {
            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_news_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        News $news,
        FileUploader $fileUploader,
    ): Response {
        [ $form, $result ] = $this->handleForm(
            request: $request,
            fileUploader: $fileUploader,
            news: $news
        );

        if ($result) {
            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/edit.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete' . $news->getId(), $request->request->get('_token'))) {
            $this->service->remove($news, true);
        }

        return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/slide/drop/{id}')]
    public function dropSlide(Slide $slide, SlideRepositoryInterface $slideRepository): JsonResponse
    {
        $slideRepository->remove($slide, true);

        return new JsonResponse(['success' => true]);
    }

    private function handleForm(
        Request $request,
        FileUploader $fileUploader,
        News $news
    ): array {
        $form = $this->createForm(NewsFormType::class, $news);
        $form->handleRequest($request);
        $result = false;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ?UploadedFile[] $slides */
            $slides = $form['uploadSlides']->getData();
            if (!empty($slides)) {
                foreach ($slides as $slide) {
                    $news->addSlide((new Slide())->setName($fileUploader->upload($slide))->setNews($news));
                }
            }
            $this->service->save($news, true);

            $result = true;
        }

        return [$form, $result];
    }
}
