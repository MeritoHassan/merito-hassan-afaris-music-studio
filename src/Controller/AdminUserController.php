<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use App\Helper\Helper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/user')]
#[IsGranted('ROLE_ADMIN')]
final class AdminUserController extends AbstractController
{
    #[Route(name: 'app_admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!Helper::checkEmail($user->getEmail())) {
                $this->addFlash('error', 'Votre adresse email est invalide!');

                return $this->render('admin_user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            if ($userRepository->findOneBy(['username' => $user->getUsername()])) {
                $this->addFlash('error', 'Ce nom d\'utilisateur est deja utilise.');

                return $this->render('admin_user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            if ($userRepository->findOneBy(['email' => $user->getEmail()])) {
                $this->addFlash('error', 'Cette adresse email est deja utilisee.');

                return $this->render('admin_user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            $plainPassword = (string) $form->get('plainPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository
    ): Response
    {
        $form = $this->createForm(UserForm::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!Helper::checkEmail($user->getEmail() )){
                $this->addFlash('error', 'Votre adresse email est invalide!');

                return $this->render('admin_user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            $userWithSameUsername = $userRepository->findOneBy(['username' => $user->getUsername()]);
            if ($userWithSameUsername && $userWithSameUsername->getId() !== $user->getId()) {
                $this->addFlash('error', 'Ce nom d\'utilisateur est deja utilise.');

                return $this->render('admin_user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            $userWithSameEmail = $userRepository->findOneBy(['email' => $user->getEmail()]);
            if ($userWithSameEmail && $userWithSameEmail->getId() !== $user->getId()) {
                $this->addFlash('error', 'Cette adresse email est deja utilisee.');

                return $this->render('admin_user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }

            $plainPassword = (string) $form->get('plainPassword')->getData();

            if ($plainPassword !== '') {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
