<?php

namespace App\Controller;

use App\DataFixtures\CategoryFixtures;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Produit;
use App\Entity\Client;
use App\Entity\Panier;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;



class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function showAllProduits(){
        
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

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

     /**
     * @Route("/produit/{id}", name="produitbyid")
     */
    public function showAllProduit($id){
        
        $repository = $this->getDoctrine()->getRepository(Produit::class);
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

     #Ajout d'un produit dans un panier, on lui passe l'id du produit à ajouter et l'email du client

    /**
     * @Route("panier/ajout/produit/{id}/{emailClient}", name="produitPanier")
     */
    public function showAddProdInPanierWithClient($id, $emailClient){

        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        
        $produit = $repository->find($id);

        $client = $clientRepository->findOneBy(['emailClient' => $emailClient]);

        $panier = new Panier();
        
        $panier->setIdClient($client);
        $panier->setIdCommande(null);
        $panier->setIdPanier((string) $id. "PAN");
        $panier->addProduit($produit);

        #enregistrement du panier dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($panier);
        $em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($panier, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

     #Ajout d'un produit dans un panier, on lui passe l'id du produit à ajouter

    /**
     * @Route("panier/ajout/produit/{id}", name="ajoutproduitPanierSansClient")
     */
    public function showAddProdInPanierSansClient($id){

        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $produit = $repository->find($id);
        $panier = new Panier();
        $panier->setIdClient(null);
        $panier->setIdCommande(null);
        $panier->setIdPanier((string) $id. "PAN");
        $panier->addProduit($produit);

        #enregistrement du panier dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($panier);
        $em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($panier, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }
}