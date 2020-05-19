<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Person;
use App\Form\CategoryType;
use App\Form\PersonType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * Ici on demande en parametre de notre methode de controller un objet de type Category
     * Catregory etant une entité, Doctrine va essayer d'utiliser les parametres de la route pour retrouver l'entité Category correspondant a l'id passé dans la route
     *
     * @Route("/{id}/view", name="category_view", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function viewCategory(Category $category)
    {
        return $this->render('category/view.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/list", name="category_list", methods={"GET"})
     */
    public function listCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/add", name="category_add", methods={"GET", "POST"})
     *
     */
    /**
     * @Route("/add", name="category_add", methods={"GET", "POST"})
     */
    public function addCategory(Request $request)
    {
        //Crée une entité qui sera gérer par le formulaire
        $newCategory = new Category();
        // Crée le formulaire vide
        // je donnée au builder l'objet qui devra etre géré par le formulaire
        /*$builder = $this->createFormBuilder($newCategory);
        $builder->add("label", TextType::class, ["label" => "Libellé de la catégorie"]);
        $builder->add("submit", SubmitType::class, ["label" => "Valider"]);
        $form = $builder->getForm();*/

        //Je crée un formulaire grace a ma classe CategoryType
        // Symfony va automatiquement appeler la methode buildForm() de cette classe
        $form = $this->createForm(CategoryType::class, $newCategory);



        // je demande au formulaire de traiter la request
        // on va recupérer les données du GET/POST
        // on  va remplir l'objet sous-jacent
        $form->handleRequest($request);
        // A ce moment le formualire sait si des données ont été postées
        if($form->isSubmitted()) {
            // si des données ont été soumises , on traite le formulaire
            //$data = $form->getData();
            // pas besoin de ce getData car l'objet  géré par le formulaire c'est $newCategory
            //$data = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newCategory);
            $manager->flush();
            return $this->redirectToRoute('category_list');
        }

        // on envoi le formulaire a la template
        return $this->render(
            'category/add.html.twig',
            [
                "categoryForm" => $form->createView()
            ]
        );
    }
    /**
     * @Route("/{id}/update", name="category_update", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     */
    public function updateCategory(Request $request, Category $category)
    {

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            // Pas besoin de persist, l'objet manipulé est déjà connu du manager
            $manager->flush();

            return $this->redirectToRoute('category_view', ['id' => $category->getId()]);
        }

        return $this->render('category/update.html.twig', [
            "categoryForm" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete", name="category_delete", methods={"GET"})
     */
    public function delete($id) {
        // je recupère mon entité
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        // je demande le manager
        $manager = $this->getDoctrine()->getManager();
        // je dit au manager que cette entité devra faire l'objet d'une suppression
        $manager->remove($category);
        // je demande au manager d'executer dans la BDD toute les modifications qui ont été faites sur les entités
        $manager->flush();
        // On retourne sur la liste des films
        return $this->redirectToRoute('category_list');
    }
}
