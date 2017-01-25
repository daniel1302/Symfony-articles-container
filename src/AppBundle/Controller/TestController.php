<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\AccountQuestion;
use AppBundle\Entity\QuestionAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Test;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class TestController extends Controller
{
    /**
     * @var Test
     */
    private $test;
    private $questionNo;

    public function indexAction()
    {
        $em = $this->getDoctrine();

        return $this->render('AppBundle:Test:index.html.twig', [
            'tests' => $em->getRepository(Test::class)->findAll()
        ]);
    }

    public function startAction(Request $request, Test $test)
    {
        $em = $this->getDoctrine();
        $repositoryAccountQuestion = $em->getRepository(AccountQuestion::class);

        $answered = $repositoryAccountQuestion->getAnsweredForTest($test, $this->getUser());
        $points = [];
        foreach ($answered as $answer) {
            $points[$answer->getQuestionId()] = $answer->getPoints();
        }

        return $this->render('AppBundle:Test:start.html.twig', [
            'test' => $test,
            'points' => $points
        ]);
    }

    public function questionAction(Request $request, Test $test, $questionNo)
    {
        if (empty($this->getUser())) {
            $request
                ->getSession()
                ->getFlashBag()
                ->add('error', 'Żeby wypełnić test zaloguj się!');
            return $this->redirectToRoute('test_start', ['slug' => $test->getSlug()]);
        }

        $em = $this->getDoctrine()->getManager();


        $this->test = $test;
        $this->questionNo = $questionNo;
        $repositoryQuestion = $em->getRepository(Question::class);
        $repositoryAnswer = $em->getRepository(Answer::class);
        $repositoryAccountQuestion = $em->getRepository(AccountQuestion::class);
        $question = $repositoryQuestion->getQuestionForTest($test, $questionNo);

        if (empty($question)) {
            return $this->redirectToRoute('test_start', ['slug' => $test->getSlug()]);
        }

        $answers = $repositoryAnswer->getSortedForQuestion($question);



        if ($repositoryAccountQuestion->isAnswered($question, $this->getUser())) {
            return $this->redirectToRoute('test_question', ['slug' => $test->getSlug(), 'questionNo' => $questionNo + 1]);
        }

        $form = $this->createQuestionForm($answers);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (is_array($data['answers'])) {
                $data['answers'] = current($data['answers']);
            }

            $selectedAnswer = $repositoryAnswer->find($data['answers']);

            if (empty($selectedAnswer) || $selectedAnswer->getQuestion()->getId() !== $question->getId()) {
                return $this->redirectToRoute('test_question', ['slug' => $test->getSlug(), 'questionNo' => $questionNo]);
            }

            $validAnswers = $this->countValidAnswers($answers);
            $selectedValid = $this->countValidAnswers([$selectedAnswer]);

            if ($validAnswers < 1) {
                $points = 0;
            } else {
                $points = round($selectedValid / $validAnswers * $question->getScore());
            }

            $accountQuestion = new AccountQuestion();
            $accountQuestion->setQuestion($question);
            $accountQuestion->setAccount($this->getUser());
            $accountQuestion->setFillDate(new \DateTime('now'));
            $accountQuestion->setPoints($points);
            $em->persist($accountQuestion);

            $questionAnswerEntity = new QuestionAnswer();
            $questionAnswerEntity->setQuestion($accountQuestion);
            $questionAnswerEntity->setAnswer($selectedAnswer);
            $em->persist($questionAnswerEntity);

            $em->flush();
            return $this->redirectToRoute('test_question', ['slug' => $test->getSlug(), 'questionNo' => $questionNo + 1]);
        }

        return $this->render('AppBundle:Test:question.html.twig', [
            'test' => $test,
            'question' => $question,
            'questionNo' => $questionNo,
            'form' => $form->createView()
        ]);
    }

    public function rankAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryAccount = $em->getRepository(Account::class);


        $accounts = $repositoryAccount->getTestRank();

        return $this->render('AppBundle:Test:rank.html.twig', [
            'accounts' => $accounts,
            'me' => $this->getUser()
        ]);
    }


    private function createQuestionForm(array $answers)
    {
        $type = $this->getAnswerType($answers);
        $form = $this->createFormBuilder();
        $form->setMethod('POST');
        $form->setAction($this->generateUrl('test_question', [
            'slug' => $this->test->getSlug(),
            'questionNo' => $this->questionNo
        ]));


        $answersArray = [];
        foreach ($answers as $answer) {
            $answersArray[$answer->getContent()] = $answer->getId();
        }

        $form->add('answers', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
            'choices' => $answersArray,
            'expanded' => $type['expanded'],
            'multiple' => $type['multiple'],
            'label' => ' '
        ]);

        return $form->getForm();
    }

    private function getAnswerType(array $answers)
    {
        if ($this->countValidAnswers($answers) > 1) {
            return ['expanded' => true, 'multiple' => true];
        }

        return ['expanded' => true, 'multiple' => false];
    }

    private function countValidAnswers(array $answers)
    {
        $i = 0;
        foreach ($answers as $answer) {
            if ($answer->getValid()) {
                $i++;
            }
        }

        return $i;
    }
}
