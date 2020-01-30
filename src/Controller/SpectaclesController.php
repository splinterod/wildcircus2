<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Entity\Spectacles;
use App\Form\SpectaclesType;
use App\Repository\OrganisationRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spectacles")
 */
class SpectaclesController extends AbstractController
{
    /**
     * @Route("/", name="spectacles_index", methods={"GET"})
     */
    public function index(SpectaclesRepository $spectaclesRepository): Response
    {
        return $this->render('spectacles/index.html.twig', [
            'spectacles' => $spectaclesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="spectacles_new", methods={"GET","POST"})
     */
    public function new(Request $request, OrganisationRepository $organisationRepository ): Response
    {
        $organisation = $organisationRepository->findOneById($_GET['id']);

        $spectacle = new Spectacles();
        $form = $this->createForm(SpectaclesType::class, $spectacle);
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
                $spectacle->setPicture($fileName);

                $spectacle->setOrganisation($organisation);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($spectacle);
                $entityManager->flush();
                $this->addFlash('success', 'Votre Pectale à été ajouté!');
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spectacle);
            $entityManager->flush();

//            return $this->redirectToRoute('organisation_index', array('organisation' => $organisation->getMail()));
            return $this->redirectToRoute('organisation_index', [
                'organisation' => $organisation->getMail()
            ], 307);

        }

        return $this->render('spectacles/new.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spectacles_show", methods={"GET"})
     */
    public function show(Spectacles $spectacle): Response
    {
        return $this->render('spectacles/show.html.twig', [
            'spectacle' => $spectacle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spectacles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Spectacles $spectacle): Response
    {
        $form = $this->createForm(SpectaclesType::class, $spectacle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spectacles_index');
        }

        return $this->render('spectacles/edit.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spectacles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Spectacles $spectacle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spectacle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spectacle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spectacles_index');
    }
}
