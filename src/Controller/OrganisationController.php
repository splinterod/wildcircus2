<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Form\Organisation1Type;
use App\Repository\OrganisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/organisation")
 */
class OrganisationController extends AbstractController
{
    /**
     * @Route("/", name="organisation_index", methods={"POST","GET"})
     */
    public function index(OrganisationRepository $organisationRepository, Request $request, $organisation="" ): Response
    {


        $user = $this->getUser();

        if (isset($_POST['mail'])) {
            $userIsOrga = $organisationRepository->findBy(['mail'=>$_POST['mail']]);
//            $request->getSession()->set(
//                Security::LAST_USERNAME,
//                $_POST['mail']
//            );
        } elseif(isset($_GET['organisation']) )
            $userIsOrga = $organisationRepository->findBy(['mail'=>$_GET['organisation']]);

        else {
            if($user == null){
                $userIsOrga = [];
            } else {
                $userIsOrga = $organisationRepository->findBy(['mail'=>$user->getMail()]);

            }
        }

        if($userIsOrga == []){
            return $this->render('organisation/login.html.twig');
        }
//        si tout est bon est deconnecte le artiste


        return $this->render('organisation/home.html.twig', [
            'organisation' => $userIsOrga,
        ]);
    }

    /**
     * @Route("/new", name="organisation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $organisation = new Organisation();
        $form = $this->createForm(Organisation1Type::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisation);
            $entityManager->flush();

            return $this->redirectToRoute('organisation_index');
        }

        return $this->render('organisation/new.html.twig', [
            'organisation' => $organisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organisation_show", methods={"GET"})
     */
    public function show(Organisation $organisation): Response
    {
        return $this->render('organisation/show.html.twig', [
            'organisation' => $organisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="organisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Organisation $organisation): Response
    {
        $form = $this->createForm(Organisation1Type::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organisation_index');
        }

        return $this->render('organisation/edit.html.twig', [
            'organisation' => $organisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Organisation $organisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('organisation_index');
    }
}
