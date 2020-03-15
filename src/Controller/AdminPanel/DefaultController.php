<?php

namespace App\Controller\AdminPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin_Cp/adminPanel", name="adminPanel")
     */
    public function index()
    {
        $number = random_int(0, 100);

        return $this->render('AdminPanel/Default/index.html.twig', [
            'posts' => $number,
        ]);
    }
}