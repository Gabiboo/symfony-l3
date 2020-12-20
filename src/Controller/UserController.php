<?php

namespace App\Controller;

use App\Entity\Souscription;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-espace-client")
 */
class UserController extends AbstractController
{

    /**
     * @Route("", name="user_home", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        //récupère l'utilisateur connecté
        $user = $this->getUser();

        //crée un formulaire lié a cet User
        $form = $this->createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form-> isSubmitted() && $form->isValid()){
            $this-> getDoctrine()->getManager()->flush();
        }

        return $this->render('espace-client/layout.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/mes-souscriptions", name="user_souscritions", methods={"GET"})
     */
    public function souscription(Souscription $souscription, User $user): Response
    {
        $user = $this->getUser();
        $user->getSouscriptions();

        return $this->render('espace-client/souscriptions.html.twig', [
            'souscription' => $souscription,
        ]);
    }
}
