<?php

namespace App\Controller;

use App\Entity\TestEntity;
use App\Form\TestEntityType;
use App\Repository\TestEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test/entity")
 */
class TestEntityController extends AbstractController
{
    /**
     * @Route("/", name="test_entity_index", methods={"GET"})
     */
    public function index(TestEntityRepository $testEntityRepository): Response
    {
        return $this->render('test_entity/index.html.twig', [
            'test_entities' => $testEntityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="test_entity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testEntity = new TestEntity();
        $form = $this->createForm(TestEntityType::class, $testEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($testEntity);
            $entityManager->flush();

            return $this->redirectToRoute('test_entity_index');
        }

        return $this->render('test_entity/new.html.twig', [
            'test_entity' => $testEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_entity_show", methods={"GET"})
     */
    public function show(TestEntity $testEntity): Response
    {
        return $this->render('test_entity/show.html.twig', [
            'test_entity' => $testEntity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_entity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TestEntity $testEntity): Response
    {
        $form = $this->createForm(TestEntityType::class, $testEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_entity_index');
        }

        return $this->render('test_entity/edit.html.twig', [
            'test_entity' => $testEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_entity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TestEntity $testEntity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testEntity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($testEntity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_entity_index');
    }
}
