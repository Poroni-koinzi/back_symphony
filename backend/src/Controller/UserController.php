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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/user/login", name="user/login", methods={"POST"})
     */
    public function login(Request $req){
        $user = $this->getUser();

        return new Response('', Response::HTTP_CREATED);
    }

   /**
    * @Route("/user/ajout", name="ajoutuser", methods={"POST"})
    */
    public function creationClient(Request $req){
        $data = $req->getContent();
        $useone = new User();
        $email = json_decode($data, true)['email'];
        $password = json_decode($data, true)['password'];
        $useone->setEmail($email);
        $useone->setPassword($this->passwordEncoder->encodePassword($useone,$password));

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $user = $serializer->deserialize($data, User::class, 'json');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($useone);
        $em->flush();
        
        return new Response('', Response::HTTP_CREATED);
    }
}
