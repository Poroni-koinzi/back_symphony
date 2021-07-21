<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function showCommandes(){
       
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($commandes, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    /**
     * @Route("/commande/{id}", name="commandebyid")
     */
    public function showAllCommande($id){
        
        $repository = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repository->find($id);

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
}
