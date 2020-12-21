<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\UserType;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Repository\OfferRepository;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * @Route("/contact", name="contact_index", methods={"GET"})
     */
    public function indexContact(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/article", name="article_index_a", methods={"GET"})
     */
    public function indexArticle(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/indexA.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/new", name="article_new_a", methods={"GET","POST"})
     */
    public function newArticle(Request $request, FileUploader $fileUploader): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            
            if ($brochureFile) {
                
                $brochureFileName = $fileUploader->upload($brochureFile);
                
                $article->setBrochureFilename($brochureFileName);
            }

            $entityManager->persist($article);
            $entityManager->flush();


            $this->addFlash(
                'success',
                'Un article à été ajouté avec succès !'
            );
            return $this->redirectToRoute('article_index_a');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function editArticle(Request $request, Article $article, FileUploader $fileUploader): Response
    {
        $imgName = $article->getBrochureFilename();
        $article->setBrochureFilename(
            new File($this->getParameter('article_image_directory').'/'.$article->getBrochureFilename())
        );
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->setBrochureFilename($brochureFileName);
            }else{
                $article->setBrochureFilename($imgName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index_a');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'imgName' => $imgName
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show_a", methods={"GET"})
     */
    public function showUser(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="user_edit_a", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function indexUser(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/offre", name="offer_index_a", methods={"GET"})
     */
    public function indexOffer(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/indexA.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }
    
}
