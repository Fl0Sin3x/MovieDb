<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\MovieActor;
use App\Entity\Person;
use App\Form\CategoryType;
use App\Form\MovieActorType;
use App\Form\MovieType;
use App\Service\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
// On aurait utiliser le slugger avec une injection de dépendances
    // Cette technique peut remplacer l'usage des paramètres dans les méthodes
    // Si, par exemple, on utilisait le Slugger dans toutes les méthodes de ce contrôleur,
    // on pourrait se faciliter la tâche pour accéder au Slugger
    // sans avoir à taper `Slugger $slugger` partout
    // Il faudra cependant utiliser $this->slugger et non $slugger dans nos méthodes de contrôleur
    // private $slugger;

    // public function __construct(Slugger $slugger)
    // {
    //     $this->slugger = $slugger;
    // }

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
    public function view($id, slugger $slugger)
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
    public function add(Request $request, Slugger $slugger)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // On ajoute le slug du $movie à partir de son titre
            $slug = $slugger->slugify($movie->getTitle());
            $movie->setSlug($slug);

            /** @var UploadedFile imageFilename  */
            $imageFilename  = $form->get('image')->getData();
            if($imageFilename ) {
                $filename = uniqid() . '.' . $imageFilename ->guessExtension();

                $imageFilename ->move(
                    $this->getParameter('images_directory'),
                    $filename
                );

                $movie->setImageFilename($filename);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($movie);
            $manager->flush();

            return $this->redirectToRoute('movie_view', ['id' => $movie->getId()]);
        }
        return $this->render('movie/add.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name="movie_delete", methods={"GET"})
     */
    public function delete($id) {
        // je recupère mon entité
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);


        // je demande le manager
        $manager = $this->getDoctrine()->getManager();
        // je dit au manager que cette entité devra faire l'objet d'une suppression
        $manager->remove($movie);
        // je demande au manager d'executer dans la BDD toute les modifications qui ont été faites sur les entités
        $manager->flush();
        $movieTitle = $movie->getTitle();
        $this->addFlash('info', "$movieTitle a été supprimé");
        // On retourne sur la liste des films
        return $this->redirectToRoute('movie_list');
    }


    /**
     * @Route("/{id}/update", name="movie_update", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     */
    public function update(Movie $movie, Request $request, Slugger $slugger)
    {

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // On recalcule le slug au cas où il a été modifié
            $movie->setSlug($slugger->slugify($movie->getTitle()));


            /** @var UploadedFile imageFilename  */
            $imageFilename  = $form->get('image')->getData();
            if($imageFilename ) {
                $filename = uniqid() . '.' . $imageFilename ->guessExtension();

                $imageFilename ->move(
                    $this->getParameter('images_directory'),
                    $filename
                );

                $movie->setImageFilename($filename);
            }

            // il manque le traitement de l'image ici
            // @TODO : Faire pareil que dans le add
            $manager = $this->getDoctrine()->getManager();
            // Pas besoin de persist, l'objet manipulé est déjà connu du manager
            $manager->flush();

            return $this->redirectToRoute('movie_view', ['id' => $movie->getId()]);
        }

        return $this->render('movie/update.html.twig', [
            "movieForm" => $form->createView(),
            "movie"=> $movie
        ]);
    }

    /**
     * @Route("/{id}/actor/add", name="movie_actor_add", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     */
    public function addMovieActor(Movie $movie, Request $request)
    {
        $movieActor = new MovieActor();
        $movieActor->setMovie($movie);

        $form = $this->createForm(MovieActorType::class, $movieActor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($movieActor);
            $manager->flush();

            return $this->redirectToRoute('movie_view', ["id" => $movie->getId()]);
        }

        return $this->render('movie/add_actor.html.twig', [
            "form" => $form->createView(),
            "movie" => $movie
        ]);
    }
}
