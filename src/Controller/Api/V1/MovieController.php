<?php

namespace App\Controller\Api\V1;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/v1/movies", name="api_v1_movies_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(MovieRepository $movieRepository, ObjectNormalizer $objetNormalizer)
    {
        $movies = $movieRepository->findAll();

        // On initialise le le Serializer en lui précisant de travailler avec le normaliseur d'objets
        $serializer = new Serializer([$objetNormalizer]);

        $json = $serializer->normalize($movies, null, ['groups' => 'api_v1_movies']);

        return $this->json($json);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Movie $movie, ObjectNormalizer $objetNormalizer)
    {
        $serializer = new Serializer([$objetNormalizer]);

        $json = $serializer->normalize($movie, null, ['groups' => 'api_v1_movies']);

        return $this->json($json);
    }

    /**
     * @Route("", name="new", methods={"POST"})
     */
    public function new(Request $request, ObjectNormalizer $objetNormalizer)
    {
        // Depuis l'installation du JWT , on peu retrouvé l'utilisateur connecté
        // comme si on avait une session classique avec un cookies
        // Pour trouver l'utilisateur :
        //$user = $this->getUser();
        //dd($user);
        // On pourrait par exemple vérifier le rôle de l'utilisateur ici
        // Encore mieux, on pourrait utiliser des Voters pour vérifier que cette utilisateur a le droit <add> sur $movie

        // Pour créer un nouveau Movie depuis une requête en API
        // on peut utiliser les formulaires
        // La structure des données permettra d'associer
        // les propriétés du JSON aux champs de notre formulaire

        $movie = new Movie();
        // L'option supplémentaire permet de ne pas vérifier le token CSRF
        // Comme on est en API, les requêtes sont forcément forgées,
        // elles proviennent d'utilisateurs qu'on pourra identifier, la protection CSRF est injustifiée ici
        $form = $this->createForm(MovieType::class, $movie, ['csrf_protection' => false]);

        // L'option true (deuxième argument de json_decode(), permet de spécifier qu'on veut un arra yet pas un objet)
        $json = json_decode($request->getContent(), true);

        // On simule l'envoi du formulaire
        $form->submit($json);

        // On vérifie que les données reçues sont valides selon les contraintes de validation qu'on connait
        if ($form->isValid()) {

            // Ça y est, les données de la requête ont été associées à notre formulaire puis à $movie
            // Il ne reste plus qu'à persister $movie
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            // Tout a bien fonctionné, on sérialise $movie pour l'afficher
            // Ça sert de confirmation
            $serializer = new Serializer([$objetNormalizer]);
            $movieJson = $serializer->normalize($movie, null, ['groups' => 'api_v1_movies']);

            // On précise le code de status de réponse 201 Created
            return $this->json($movieJson, 201);
        } else {
            // Si le formulaire n'est pas valide, on peut renvoyer les erreurs
            // Attention il s'agit d'une chaine de caractères qui n'explique pas grand chose,
            // Ce n'est pas du JSON, il y a sûrement un moyen, à la main, de sérialiser les erreurs mieux que ça
            // On précise également le code de status de réponse : 400
            // (string) c'est pour parser (transformer) notre objet en string
            return $this->json((string) $form->getErrors(true), 400);
        }
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update()
    {
        return $this->json([
            'message' => 'coucou c\'est le GET',
            'path' => 'src/Controller/Api/V1/MovieController.php',
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete()
    {
        return $this->json([
            'message' => 'coucou c\'est le GET',
            'path' => 'src/Controller/Api/V1/MovieController.php',
        ]);
    }
}
