<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-espace-agent")
 */
class AgentController extends AbstractController
{
    /**
     * @Route("", name="agent")
     */
    public function index()
    {
        return $this->render('agent/index.html.twig', [
            'controller_name' => 'AgentController',
        ]);
    }
}
