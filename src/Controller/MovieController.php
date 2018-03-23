<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{

    /**
     * @Route("/movie", name="movie")
     */
    public function getMovies() {

        return $this->render('movie/movies.html.twig');
    }
}