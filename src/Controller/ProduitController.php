<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,SluggerInterface $slugger): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $originalExtension = $file->guessExtension();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $originalExtension;
                $file->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
            }
            $produit->setImage($newFilename);
            $entityManager->persist($produit);
            $entityManager->flush();
            $this->addFlash('success', 'Produit créé avec succès! ');

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Produit modifié avec succès! ');

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
            $this->addFlash('success', 'Produit supprimé avec succès! ');
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/produit-statistics", name="produit_statistics")
     */
    public function produitStatistics(ProduitRepository $produitRepository): Response
    {
        // Récupérer les statistiques sur le nombre de produits par catégorie
        $produitStats = $produitRepository->countProduitsByCategorie();

        return $this->render('categorie/produit_statistics.html.twig', [
            'produitStats' => $produitStats,
        ]);
    }
    #[Route('/rechercher-produits-par-nom', name: 'rechercher_produits_par_nom', methods: ['GET'])]
    public function rechercherProduitsParNom(Request $request, ProduitRepository $produitRepository): JsonResponse
    {
        $searchTerm = $request->query->get('searchTerm');

        // Recherche de produits par nom
        $produits = $produitRepository->rechercherParNom($searchTerm);

        // Préparer les données à renvoyer au format JSON
        $jsonData = [];
        foreach ($produits as $produit) {
            $jsonData[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                // Ajoutez d'autres propriétés de produit à renvoyer si nécessaire
            ];
        }

        return new JsonResponse($jsonData);
    }
    #[Route('/download-products-pdf', name: 'app_produit_download_pdf', methods: ['GET'])]
    public function downloadProductsPdf(ProduitRepository $produitRepository): Response
    {
        // Récupérer la liste des produits
        $produits = $produitRepository->findAll();
    
        // Configuration de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
    
        // Générer le contenu PDF avec les produits
        $html = $this->renderView('produit/pdf.html.twig', [
            'produits' => $produits,
        ]);
    
        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);
    
        // Générer le PDF
        $dompdf->render();
    
        // Envoyer le PDF en réponse HTTP
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="products.pdf"');
    
        return $response;
    }
    #[Route('/trier-par-prix', name: 'app_trier_par_prix', methods: ['GET'])]
    public function trierParPrix(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findBy([], ['prix' => 'ASC']);

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }
   
 

}
