<?php
namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuizController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/quiz', name: 'quiz_index')]
    public function index(): Response
    {
        $quizRepository = $this->entityManager->getRepository(Quiz::class);
        $quizzes = $quizRepository->findAll();
        dump($quizzes);

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    #[Route('/quiz/create', name: 'quiz_create')]
    public function create(Request $request): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($quiz);
            $this->entityManager->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/quiz/edit/{id}', name: 'quiz_edit')]
    public function edit(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/edit.html.twig', [
            'form' => $form->createView(),
            'quiz' => $quiz,
        ]);
    }

    #[Route('/quiz/delete/{id}', name: 'quiz_delete')]
    public function delete(Quiz $quiz): Response
    {
        $this->entityManager->remove($quiz);
        $this->entityManager->flush();

        return $this->redirectToRoute('quiz_index');
    }

    #[Route('/quiz/{id}', name: 'quiz_show')]
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}
