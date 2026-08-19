<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireForm;
use App\Repository\CommentaireRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    private const POSTS_PER_PAGE = 6;

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        $post_last_3 = $postRepository->findLatest(3);

        return $this->render('home/index.html.twig', [
            'posts' => $post_last_3
        ]);
    }

    #[Route('/postList', name: 'app_postList')]
    public function postList(Request $request, PostRepository $postRepository): Response
    {
        $totalPosts = $postRepository->countAll();
        $totalPages = max(1, (int) ceil($totalPosts / self::POSTS_PER_PAGE));
        $page = min(max(1, $request->query->getInt('page', 1)), $totalPages);

        return $this->render('home/postList.html.twig', [
            'posts' => $postRepository->findPaginated($page, self::POSTS_PER_PAGE),
            'current_page' => $page,
            'total_pages' => $totalPages,
        ]);
    }

    #[Route('/postList/{id}', name: 'app_postList_show', methods: ['GET', 'POST'])]
    public function show(
        Post $post,
        Request $request,
        EntityManagerInterface $em,
        CommentaireRepository $commentaireRepository
    ): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireForm::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->getUser()) {
                $this->addFlash('error', 'Vous devez etre connecte pour laisser un commentaire.');

                return $this->redirectToRoute('app_login');
            }

            $commentaire->setAuteur($this->getUser());
            $commentaire->setPost($post);
            $commentaire->setDateHeureCreation(new \DateTime());
            $commentaire->setSignale(false);

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('app_postList_show', ['id' => $post->getId()]);
        }

        return $this->render('home/post.html.twig', [
            'post' => $post,
            'commentaire_form' => $form->createView(),
            'commentaires' => $commentaireRepository->findByPostOrdered($post->getId()),
        ]);
    }

    #[Route('/commentaire/{id}/report', name: 'app_comment_report', methods: ['POST'])]
    public function reportComment(
        Commentaire $commentaire,
        Request $request,
        EntityManagerInterface $entityManager
    ): RedirectResponse {
        if (!$this->isCsrfTokenValid('report'.$commentaire->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Le signalement du commentaire a echoue.');

            return $this->redirectToRoute('app_postList_show', ['id' => $commentaire->getPost()->getId()]);
        }

        if (!$commentaire->isSignale()) {
            $commentaire->setSignale(true);
            $entityManager->flush();
            $this->addFlash('success', 'Le commentaire a bien ete signale.');
        } else {
            $this->addFlash('info', 'Ce commentaire a deja ete signale.');
        }

        return $this->redirectToRoute('app_postList_show', ['id' => $commentaire->getPost()->getId()]);
    }
}
