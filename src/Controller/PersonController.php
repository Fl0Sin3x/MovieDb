<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Person;
use App\Form\CategoryType;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;


/**
 * @Route("/person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/{id}/view", name="person_view", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function viewCategory($id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findWithFullData($id);
        return $this->render('person/view.html.twig', [
            'person' => $person,
        ]);
    }

    /**
     * @Route("/add", name="person_add", methods={"GET", "POST"})
     */
    public function addPerson(Request $request)
    {
        $newPerson = new Person();
        $form = $this->createForm(PersonType::class, $newPerson);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newPerson);
            $manager->flush();
            $this->addFlash("success", "La personne a été ajoutée");
            return $this->redirectToRoute('person_view', ['id' => $newPerson->getId() ]);
        }

        return $this->render('person/add.html.twig', [
            "personForm" => $form->createView()
        ]);


    }
    /**
     * @Route("/{id}/update", name="person_update", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     */
    public function updatePerson(Request $request, Person $person)
    {
        // Pas besoin de créer une entité, j'utilise celle recupérée depuis la BDD
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            // Pas besoin de persist, l'objet manipulé est déjà connu du manager
            $manager->flush();
            $this->addFlash("success", "La personne a été mise à jour");
            return $this->redirectToRoute('person_view', ['id' => $person->getId()]);
        }

        return $this->render('person/update.html.twig', [
            "personForm" => $form->createView(),
            "person" => $person


        ]);
    }
    /**
     * @Route("/{id}/delete", name="person_delete", methods={"GET"})
     */
    public function delete($id) {
        // je recupère mon entité
        $person = $this->getDoctrine()->getRepository(Person::class)->find($id);
        $personName = $person->getName();

        if(!$person->getDirectedMovies()->isEmpty()) {
            $this->addFlash('info', "Supprimer $personName ne sera possible que s'il n'est plus réalisateur");
            return $this->redirectToRoute('person_update', ['id' => $person->getId()]);
        }
        // je demande le manager
        $manager = $this->getDoctrine()->getManager();
        // je dit au manager que cette entité devra faire l'objet d'une suppression
        $manager->remove($person);
        // je demande au manager d'executer dans la BDD toute les modifications qui ont été faites sur les entités
        $manager->flush();
        $personName = $person->getName();
        $this->addFlash('alert alert-danger', "$personName a été supprimée");
        // On retourne sur la liste des films
        return $this->redirectToRoute('movie_list');
    }
}