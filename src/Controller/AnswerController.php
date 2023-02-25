<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Vote;
use App\Entity\VoterAnswers;
use App\Entity\Voter;
use App\Form\VoterFormType;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/answer/{voteID}', name: 'app_answer', requirements: ['voteID' => '\w{32}'])]
    public function index($voteID, Request $request): Response
    {
        // get the vote by the url key
        $em = $this->doctrine->getManager();
        $vote = $em->getRepository(Vote::class)->findOneBy(['urlKey' => $voteID]);
#$sums = $vote->getAnswerSums();
#dd($sums);
        // if the vote does not exists, return with 404
        if (!$vote) {
            throw $this->createNotFoundException('No vote found for key '.$voteID);
        }

        // create a new voter with all empty answers of this vote and give it to the vote
        $voter = new Voter();
        foreach($vote->getAnswers() as $answer) {
            $vote_answer = new VoterAnswers();
            $voter->addAnswer($vote_answer);
        }
        $voter->setVoteID($vote);

        // use symfony form handler to create the form for the voter
        $form = $this->createForm(VoterFormType::class, $voter);

        // handle the form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voter);
            $em->flush();
            return $this->redirect('/answer/'.$voteID);
        }

        // render form
        return $this->render('answer/index.html.twig', [
            'form' => $form,
            'vote' => $vote
        ]);
    }

    #[Route('/voter_delete/{voteID}/{voterID}', name: 'voter_delete', requirements: ['voteID' => '\w{32}', 'voterID' => '\d+'])]
    public function deleteVoter($voteID, $voterID): Response
    {
        // get the vote by the url key
        $em = $this->doctrine->getManager();
        $vote = $em->getRepository(Vote::class)->findOneBy(['urlKey' => $voteID]);

        $vote->removeVoter($em->getRepository(Voter::class)->findOneBy(['id' => $voterID]));
        $em->persist($vote);
        $em->flush();

        return $this->redirect('/answer/'.$voteID);
    }
}
