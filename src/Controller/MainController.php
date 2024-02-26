<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use App\Repository\CrudRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(CrudRepository $repo): Response
    {
        #$data = $this->getDoctrine()->getRepository(Crud::class)->findAll();
        $datas = $repo->findAll();
        return $this->render('main/AfficheArticle.html.twig', [
            'controller_name' => 'MainController',
            'datas'=>$datas,
        ]);
    }
    /**
     * @Route("/create", name="create", methods: ['GET','POST'])
     */
    public function create(Request $request): Response
    {
        $crud = new Crud();#entity
        $form = $this->createForm(CrudType::class, $crud);#form
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->persist($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Soumission réussi !!');

            return $this->redirectToRoute('main');
        }


        return $this->render('main/createForm.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/update/{id}", name="update", methods: ['GET','POST'])
     */
    public function update($id,Request $request ): Response
    {

        $crud = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->persist($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Modification réussi !!');

            return $this->redirectToRoute('main');
        }


        return $this->render('main/updateForm.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {

        $crud = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $sendDatabase = $this->getDoctrine()
                             ->getManager();
        $sendDatabase->remove($crud);
        $sendDatabase->flush();

            $this->addFlash('notice', 'Suppression réussi !!');

            return $this->redirectToRoute('main');
        }
}
