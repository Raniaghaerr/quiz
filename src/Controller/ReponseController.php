<?php
namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reponse', name: 'reponse_index')]
    public function index(): Response
    {
        $reponseRepository = $this->entityManager->getRepository(Reponse::class);
        $reponses = $reponseRepository->findAll();

        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponses,
        ]);
    }

    #[Route('/reponse/create', name: 'reponse_create')]
    public function create(Request $request): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($reponse);
            $this->entityManager->flush();

            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reponse/edit/{id}', name: 'reponse_edit')]
    public function edit(Request $request, Reponse $reponse): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/edit.html.twig', [
            'form' => $form->createView(),
            'reponse' => $reponse,
        ]);
    }

    #[Route('/reponse/delete/{id}', name: 'reponse_delete')]
    public function delete(Reponse $reponse): Response
    {
        $this->entityManager->remove($reponse);
        $this->entityManager->flush();

        return $this->redirectToRoute('reponse_index');
    }

    #[Route('/reponse/{id}', name: 'reponse_show')]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }
}
