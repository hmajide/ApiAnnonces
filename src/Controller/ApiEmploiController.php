<?php

namespace App\Controller;

use App\Repository\EmploiRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Emploi;


class ApiEmploiController extends AbstractController
{
    /**
     * @Route("/api/emplois", name="api_emplois", methods={"GET"})
     */
    public function show(EmploiRepository $repo, SerializerInterface $serializer )
    {
        $emplois= $repo->findAll();
        $resultat=$serializer->serialize(
            $emplois,
            'json',
            [
                'groups'=>['listEmploiFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/emplois/{id}", name="api_emplois_show", methods={"GET"})
     */
    public function list( Emploi $emploi, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $emploi,
            'json',
            [
                'groups'=>['listEmploiFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/emplois", name="api_emplois_create", methods={"POST"})
     */
    public function create(Request $request ,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data=$request->getContent();
        //$emploi =new Emploi();
        //$serializer->deserialize($data, Emploi::class,'json',['object_to_populate'=>$emploi]);
        $emploi=$serializer->deserialize($data, Emploi::class,'json');
        $manager->persist($emploi);
        $manager->flush();
        // Generate URL Absolute
        return new JsonResponse(
            "Insertion ok",Response::HTTP_CREATED,["location"=> $this->generateUrl('api_emplois_show',["id"=>$emploi->getId()],
            Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL)],true );
        // return new JsonResponse("insert bdd OK", 201,["location"=>"api/emploi/".$emploi->getId()
        //],true);
    }

    /**
     * @Route("/api/emplois/{id}", name="api_emplois_update", methods={"PUT"})
     */
    public function edit( Emploi $emploi,Request $request,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Emploi::class, 'json', ['object_to_populate' => $emploi]);
        $manager->persist($emploi);
        $manager->flush();

        return new JsonResponse("Update OK", 200, [], true);
    }

    /**
     * @Route("/api/emplois/{id}", name="api_emplois_delete", methods={"DELETE"})
     */
    public function delete( Emploi $emploi,ObjectManager $manager )
    {
        $manager->remove($emploi);
        $manager->flush();

        return new JsonResponse("Delete OK", 200, []);


    }

}