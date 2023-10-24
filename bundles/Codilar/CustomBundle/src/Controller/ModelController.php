<?php

namespace Codilar\CustomBundle\Controller;

use Codilar\CustomBundle\Model\Vote;
use Codilar\CustomBundle\Model\Listing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModelController extends AbstractController
{
    /**
     * @Route("model")
     */
    public function modelAction(Request $request): Response
    {
        
        // Create an instance of the Vote model
        // $vote = new Vote();
        // $vote->setScore(51);
        // $vote->setUsername('Baki');
        // $vote->save();

        
        $listing = new Listing();
        $listing->setCondition('score > 50');
        $listing->load();
        var_dump($listing);
        
        return $this->render('@CodilarCustom/model.html.twig',[
            'list' => $listing
        ]);
    }

    // foreach ($list as $vote) {
    //     $vote->setCondition("score > ?", [1]);
    //     $vote->load();
    // }


}

