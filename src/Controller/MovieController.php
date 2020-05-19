<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Form\CategoryType;
use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{

    /**
     * @Route("/list", name="movie_list", methods={"GET"})
     */
    public function list(Request $request) {

        $search = $request->query->get("search", "");

        /*
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy(
            ["title" => $search], // WHERE title = "search"
            ["title" => "asc"]
        );

        // on a plutot besoin d'un title LIKE "%search%"
        */

        $movies = $this->getDoctrine()->getRepository(Movie::class)->findByPartialTitle($search);

        return $this->render('movie/list.html.twig', [
            "movies" => $movies,
            "search" => $search

        ]);
    }

    /**
     * @Route("/{id}/view", name="movie_view", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function view($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findWithFullData($id);

        if(!$movie) {
            throw $this->createNotFoundException("Ce film n'existe pas !");
        }

        return $this->render('movie/view.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/add", name="movie_add", methods={"GET", "POST"})
     */
    public function add(Request $request)
    {

        $newMovie = new Movie();
        $newCategory = new Category();

        //Je crée un formulaire grace a ma classe CategoryType
        // Symfony va automatiquement appeler la methode buildForm() de cette classe
        $form = $this->createForm(MovieType::class, $newMovie);

        $form->handleRequest($request);
        // A ce moment le formualire sait si des données ont été postées
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newMovie);
            $manager->flush();
            return $this->redirectToRoute('movie_view', ['id' => $newMovie->getId() ]);
        }

        // on envoi le formulaire a la template
        return $this->render(
            'movie/add.html.twig',
            [
                "formMovie" => $form->createView()
            ]
        );
    }


    /**
     * @Route("/{id}/delete", name="movie_delete", methods={"GET"})
     */
    public function delete($id) {
        // je recupère mon entité
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

        // si le film n'éxiste pas on renvoi sur une 404
        if(!$movie) {
            throw $this->createNotFoundException("Ce film n'existe pas !");
        }

        // je demande le manager
        $manager = $this->getDoctrine()->getManager();
        // je dit au manager que cette entité devra faire l'objet d'une suppression
        $manager->remove($movie);
        // je demande au manager d'executer dans la BDD toute les modifications qui ont été faites sur les entités
        $manager->flush();
        // On retourne sur la liste des films
        return $this->redirectToRoute('movie_list');
    }


    /**
     * @Route("/{id}/update", name="movie_update", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     */
    public function update(Movie $movie, Request $request)
    {

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            // Pas besoin de persist, l'objet manipulé est déjà connu du manager
            $manager->flush();

            return $this->redirectToRoute('movie_view', ['id' => $movie->getId()]);
        }

        return $this->render('movie/update.html.twig', [
            "movieForm" => $form->createView()
        ]);




    }

}
