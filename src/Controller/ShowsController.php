<?php

namespace App\Controller;

use App\Entity\Shows;
use App\Form\Shows1Type;
use App\Repository\OrganisationRepository;
use App\Repository\ShowsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shows")
 */
class ShowsController extends AbstractController
{
    /**
     * @Route("/", name="shows_index", methods={"GET"})
     */
    public function index(ShowsRepository $showsRepository, OrganisationRepository $organisationRepository): Response
    {
        $userIsOrga = $organisationRepository->findBy(['id'=>$_GET['id']]);


        return $this->render('shows/index.html.twig', [
            'shows' => $showsRepository->findAll(),
            'organisateurs' => $userIsOrga
        ]);
    }

    /**
     * @Route("/new", name="shows_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $artiste = $this->getUser();

        $show = new Shows();
        $form = $this->createForm(Shows1Type::class, $show);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['picture']->getData();

            if ($file) {
                $fileName = 'Image' . uniqid() . '.' . $file->guessExtension();
//                 moves the file to the directory where brochures are stored
                $destination = $this->getParameter('image_user_upload');
                $file->move(
                    $destination,
                    $fileName
                );
                $show->setPicture($fileName);

                $show->setArtistes($artiste);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($show);
                $entityManager->flush();
                $this->addFlash('success', 'Votre Pectale à été ajouté!');
            }
            return $this->render('artistes/home.html.twig', [
                'user' => $artiste
            ]);
        }

        return $this->render('shows/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shows_show", methods={"GET"})
     */
    public function show(Shows $show): Response
    {
        return $this->render('shows/show.html.twig', [
            'show' => $show,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shows_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shows $show): Response
    {
        $form = $this->createForm(Shows1Type::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shows_index');
        }

        return $this->render('shows/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shows_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shows $show): Response
    {
        if ($this->isCsrfTokenValid('delete' . $show->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($show);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shows_index');
    }
}
