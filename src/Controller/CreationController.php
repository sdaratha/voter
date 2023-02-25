<?php
//https://www.prado.lt/how-to-enable-bootstrap-in-symfony-6-project
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VoteFormType;
use App\Entity\Vote;
use App\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/create', name: 'app_creation')]
    public function index(Request $request): Response
    {
        // initialize with new vote
        $vote = new Vote();

        // create an answer and give it to the vote
        $answer = new Answer();
        $vote->addAnswer($answer);

        // use symfony form handler to create the form
        $form = $this->createForm(VoteFormType::class, $vote);

        // handle the form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // create unique key for the vote
            $uniqueKey = md5(uniqid(rand(), true));
            $vote->setUrlKey($uniqueKey);

            // set creation date
            $vote->setCreationDate(new \DateTime());

            // create maanager and save vote
            $em = $this->doctrine->getManager();
            $em->persist($vote);
            $em->flush();

            // redirect to the answer page
            return $this->redirect('/answer/'.$uniqueKey);
        }

        return $this->render('creation/index.html.twig', [
            'form' => $form
        ]);
    }
}
