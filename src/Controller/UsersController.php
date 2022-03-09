<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("/", name="users_index")
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }    
    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("/admins", name="admins_index")
     */
    public function admins(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        $admins = [];
        foreach ($users as $user) {
            if (in_array("ROLE_ADMIN", $user->getRoles())) {
                $admins[] = $user;
            }
        }
        return $this->render('users/index.html.twig', [
            'users' => $admins
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("/influencers", name="influencers_index")
     */
    public function influencers(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        $influencers = [];
        foreach ($users as $user) {
            if (!in_array("ROLE_INFLUENCER", $user->getRoles())) {
                $influencers[] = $user;
            }
        }
        return $this->render('users/index.html.twig', [
            'users' => $influencers
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("/normalusers", name="normalusers_index")
     */
    public function normalusers(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        $normalusers = [];
        foreach ($users as $user) {
            if (!in_array("ROLE_ADMIN", $user->getRoles()) && !in_array("ROLE_INFLUENCER", $user->getRoles())) {
                $normalusers[] = $user;
            }
        }
        return $this->render('users/index.html.twig', [
            'users' => $normalusers
        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/enable", name="users_enable", methods={"GET"})
     */
    public function enable(Users $user): Response
    {
        $user->setIsActive(true);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('users_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/disable", name="users_disable", methods={"GET"})
     */
    public function disable(Users $user): Response
    {
        $user->setIsActive(false);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('users_index');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="users_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'You cannot edit this user');
            return $this->redirectToRoute('back');
        }
    
        $originalImage = $user->getImage();
        $form = $this->createForm(UsersType::class, $user);
        $form->add('image', FileType::class, [
            'label' => 'Profile Image',
            'mapped' => false,
            'required' => false,
            "attr" => [
                "class" => "form-control"
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            if ($file) {
                $fs = new Filesystem();
                $fs->remove($this->getParameter('profile_upload_dir') . '/' . $originalImage);

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('profile_upload_dir'), $fileName);
                $user->setImage($fileName);
            } else {
                $user->setImage($originalImage);
            }

            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('users_index');
            } else {
                return $this->redirectToRoute('home');
            }
        }
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/profile1.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        } else {        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

        } 

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="users_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_index');
    }
}
