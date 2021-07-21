<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Avis;
use Symfony\Component\HttpFoundation\Response;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis")
     */
    public function showCategory(){
       
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($avis, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }

    /**
     * @Route("/avis/{id}", name="avisbyid")
     */
    public function showAllCategory($id){
        
        $repository = $this->getDoctrine()->getRepository(Avis::class);
        $avis = $repository->find($id);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($avis, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
         $response = new Response($data);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
    }
}
