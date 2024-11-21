<?php
namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;  // Assure-toi d'importer l'entité Quiz
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/question', name: 'question_index')]
    public function index(): Response
    {
        // Récupère toutes les questions
        $questionRepository = $this->entityManager->getRepository(Question::class);
        $questions = $questionRepository->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            
        ]);
    }

    #[Route('/question/create/{quizId}', name: 'question_create')]
    public function create(Request $request, $quizId): Response
    {
        // Récupère le quiz à partir de l'ID
        $quiz = $this->entityManager->getRepository(Quiz::class)->find($quizId);

        // Vérifie si le quiz existe
        if (!$quiz) {
            throw $this->createNotFoundException('Quiz not found');
        }

        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associe la question au quiz
            $question->setQuiz($quiz);

            // Enregistre la question en base
            $this->entityManager->persist($question);
            $this->entityManager->flush();

            // Redirige vers la liste des questions du quiz
            return $this->redirectToRoute('question_index', ['quizId' => $quiz->getId()]);
        }

        return $this->render('question/create.html.twig', [
            'form' => $form->createView(),
            'quiz' => $quiz,
        ]);
    }

    // Autres méthodes pour éditer, afficher et supprimer les questions...
}
