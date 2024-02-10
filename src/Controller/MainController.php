<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/create", name="app_main")
     */
    public function create(Request $request): Response
    {
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->persist($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Soumission réussi !!');
        }


        return $this->render('main/createForm.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }
}
