<?php

namespace App\Controller;

use App\Repository\ImmobilierRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Immobilier;


class ApiImmobilierController extends AbstractController
{
    /**
     * @Route("/api/immobiliers", name="api_immobiliers", methods={"GET"})
     */
    public function show(ImmobilierRepository $repo, SerializerInterface $serializer )
    {
        $immobilers= $repo->findAll();
        $resultat=$serializer->serialize(
            $immobilers,
            'json',
            [
                'groups'=>['listImmobilierFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/immobilers/{id}", name="api_immobilers_show", methods={"GET"})
     */
    public function list( Immobilier $immobilier, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $immobilier,
            'json',
            [
                'groups'=>['listImmobilierFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/immobilers", name="api_immobilers_create", methods={"POST"})
     */
    public function create(Request $request ,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data=$request->getContent();
        //$immobilier =new Immobilier();
        //$serializer->deserialize($data, Immobilier::class,'json',['object_to_populate'=>$immobilier]);
        $immobilier=$serializer->deserialize($data, Immobilier::class,'json');
        $manager->persist($immobilier);
        $manager->flush();
        // Generate URL Absolute
        return new JsonResponse(
            "Insertion ok",Response::HTTP_CREATED,["location"=> $this->generateUrl('api_immobilers_show',["id"=>$immobilier->getId()],
            Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL)],true );
        // return new JsonResponse("insert bdd OK", 201,["location"=>"api/immobilier/".$immobilier->getId()
        //],true);
    }

    /**
     * @Route("/api/immobilers/{id}", name="api_immobilers_update", methods={"PUT"})
     */
    public function edit( Immobilier $immobilier,Request $request,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Immobilier::class, 'json', ['object_to_populate' => $immobilier]);
        $manager->persist($immobilier);
        $manager->flush();

        return new JsonResponse("Update OK", 200, [], true);
    }

    /**
     * @Route("/api/immobilers/{id}", name="api_immobilers_delete", methods={"DELETE"})
     */
    public function delete( Immobilier $immobilier,ObjectManager $manager )
    {
        $manager->remove($immobilier);
        $manager->flush();

        return new JsonResponse("Delete OK", 200, []);


    }

}