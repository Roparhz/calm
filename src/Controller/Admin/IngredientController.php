<?php

namespace App\Controller\Admin;

use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'ingredient_index')]
    public function index(Request $request, IngredientRepository $ingredientRepository): Response
    {
        $ingredients = $ingredientRepository->findAll();
        $form = $this->createForm(IngredientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();
            $ingredientRepository->add($ingredient, 2);
            $this->addFlash('success', 'Votre ingrédient a bien été créé');
            return $this->redirectToRoute('ingredient_index');
        }

        return $this->render('admin/create-ingredient.html.twig', [
            'ingredients' => $ingredients,
            'ingredient_form' => $form->createView(),
        ]);

    }
}
