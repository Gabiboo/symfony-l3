<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Souscription;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offer")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function indexOffer(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="offer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index');
    }
         
    /**
     * @Route("/souscrire/{id}", name="offer_subscribe", methods={"GET","POST"})
     */
    public function subscribeToOffer(Request $request, Offer $offer): Response
    {
        $user = $this->getUser();
        
        if ($user) {
            $hasAllDataFilledOut = (
                $user->getTelephone() != NULL AND
                $user->getVille() != NULL AND
                $user->getCodePostal() != NULL AND
                $user->getPays() != NULL AND
                $user->getNumeroDeSecu() != NULL
            );
            if ($hasAllDataFilledOut) {
                $subscribedToOfferAlready = false;
                foreach ($user->getSouscriptions() as $subscription) {
                    if ($subscription->getOffers() == $offer) {
                        $subscribedToOfferAlready = true;
                        break;
                    }
                }
                if (!$subscribedToOfferAlready) {
                    $entityManager = $this->getDoctrine()->getManager();

                    $subscription = new Souscription($offer, $user);

                    $user->addSouscription($subscription);
                    $offer->addSouscription($subscription);

                    $entityManager->persist($subscription);
                    $entityManager->persist($user);
                    $entityManager->persist($offer);
                    $entityManager->flush();

                    $this->addFlash('success', 'Merci de vous être abonné à cette offre !');
                    return $this->redirectToRoute('user_souscriptions');
                } else {
                    $this->addFlash('error', 'Vous ne pouvez pas souscrire deux fois à la même offre');
                    return $this->redirectToRoute('user_souscriptions');
                }
                
            } else {
                $this->addFlash('error', 'Vous devez remplir tout le formulaire pour souscrire à une offre');
                return $this->redirectToRoute('espace_client');
            }
            
        } else {
            $this->addFlash('error', 'Vous devez être connecté pour souscrire à une nouvelle offre');
            return $this->redirectToRoute('app_login');
        }
        
    }
}
