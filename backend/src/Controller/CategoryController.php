<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function showCategory(){
        $categorie = new Category();
        $categorie->setIdCategory("imprimante");
        $categorie->setLibelleCategory("belle imprimante a tester");

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($categories, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    /**
     * @Route("/category/{id}", name="categorybyid")
     */
    public function showAllProduit($id){
        
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $produit = $repository->find($id);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($produit, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    #Envoi d'ensemble des produits d'un category specifiée en parametre 

    /**
     * @Route("/category/produits/{id}", name="categoryproduitbyid")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
    
        $produits = $product->getProduits();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($produits, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }
}
