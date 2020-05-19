<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Form\CategoryType;
use App\Form\MovieType;
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
    public function add(Request $request, SluggerInterface $slugger)
    {

        $newMovie = new Movie();
        $newCategory = new Category();

        //Je crée un formulaire grace a ma classe CategoryType
        // Symfony va automatiquement appeler la methode buildForm() de cette classe
        $form = $this->createForm(MovieType::class, $newMovie);

        $form->handleRequest($request);
        // A ce moment le formualire sait si des données ont été postées
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $newMovie->setImageFilename($newFilename);
            }
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
    public function update(Movie $movie, Request $request, SluggerInterface $slugger)
    {

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $movie->setImageFilename($newFilename);
            }
            // il manque le traitement de l'image ici
            // @TODO : Faire pareil que dans le add
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
