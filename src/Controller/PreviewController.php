<?php


namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;

class PreviewController extends AbstractController
{
    #[Route('/integration', name: 'app_integration')]
    public function index(): Response
    {
        return $this->render('front-office.html.twig');
    }

    #[Route('/events', name: 'app_events')]
    public function events(): Response
    {
        // Récupérer les données des événements depuis la base de données
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        // Rendre le template Twig en passant les données des événements
        return $this->render('event.html.twig', [
            'events' => $events,
        ]);
    }
    #[Route('/categories', name: 'app_categories')]
    public function categories(): Response
    {
        // Récupérer les données des événements depuis la base de données
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        // Rendre le template Twig en passant les données des categories
        return $this->render('categorie.html.twig', [
            'categories' => $categories,'produit'=>$produit,
        ]);
    }
    #[Route('/ghofrane', name: 'app_ghofrane')]
    public function ghofrane(): Response
    {
        return $this->render('back-office.html.twig');
    }
    /*#[Route('/ghofrane/add-student', name: 'app_add_student')]
    public function addStudent(): Response
    {
        // Votre logique pour la page add-student, par exemple, rendu d'un modèle Twig
        return $this->render('student/add-student.html.twig');
    }*/

    /*#[Route('/ghofrane/student-element', name: 'app_student_element')]
    public function studentelement(): Response
    {
        // Votre logique pour la page add-student, par exemple, rendu d'un modèle Twig
        return $this->render('student/student-element.html.twig');
    }*/

}