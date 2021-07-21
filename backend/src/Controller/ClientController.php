<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="enregistrementClient")
     */
    public function showClients(){
       
        $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($clients, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         

         return $response;
    }

    /**
     * @Route("/client/{id}", name="clientbyid")
     */
    public function showAllClient($id){
        
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($id);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($client, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    

    /**
     * @Route("/ajout/client", name="ajoutClient")
     * @Method({"POST"})
     */
    
    public function achatAction(Request $req){
        $data = $req->getContent();
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $client = $serializer->deserialize($data, Client::class, 'json');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        
        return new Response('', Response::HTTP_CREATED);
    }
}

