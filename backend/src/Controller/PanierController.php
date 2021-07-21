<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Panier;
use App\Entity\Commande;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function showPanier(){
       
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($paniers, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    /**
     * @Route("/panier/{id}", name="panierbyid")
     */
    public function showAllPanier($id){
        
        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->find($id);

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

    #validation du panier et son ajout dans commande
    /**
     * @Route("/panier/valider/commande/{id}/{idClient}", name="validPanierbyid")
     */
    public function ValidPanier($id, $idClient){
        
        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $clientRepo= $this->getDoctrine()->getRepository(Client::class);
        $client = $clientRepo->find($idClient);

        $panier = $repository->find($id);
        
        #creation d'une commande afin d'y mettre le panier validé en fournissant d'id du panier et l'id du client qui commande
        $commande = new Commande();
        $commande->setIdCommande((string) $id. "COMMAND001");
        $commande->setIdPanier($panier);
        $commande->setIdClient($client);
        $commande->setDateCommande(new \DateTime('now'));
        $commande->addPanier($panier);

        #enregistrement de la commande dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($commande, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    #Envoi l'ensemble des produits d'un panier

   /**
     * @Route("/panier/produit/{id}", name="panierproduits")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Panier::class)
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
