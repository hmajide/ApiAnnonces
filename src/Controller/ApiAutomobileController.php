<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\AutomobileRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Automobile;


class ApiAutomobileController extends AbstractController
{
    /**
     * @Route("/api/automobiles", name="api_automobiles", methods={"GET"})
     */
    public function show(AutomobileRepository $repo, SerializerInterface $serializer )
    {
        $automobiles= $repo->findAll();
        $resultat=$serializer->serialize(
            $automobiles,
            'json',
            [
                'groups'=>['listAutomobileFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/automobiles/{id}", name="api_automobiles_show", methods={"GET"})
     */
    public function list( Automobile $automobile, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $automobile,
            'json',
            [
                'groups'=>['listAutomobileSimple']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/automobiles", name="api_automobiles_create", methods={"POST"})
     */
    public function create(Request $request ,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data=$request->getContent();
        //$automobile=new Automobile();
        //$serializer->deserialize($data, Automobile::class,'json',['object_to_populate'=>$automobile]);
        $automobile=$serializer->deserialize($data, Automobile::class,'json');
        $manager->persist($automobile);
        $manager->flush();
        // Generate URL Absolute
        return new JsonResponse(
            "Insertion ok",Response::HTTP_CREATED,["location"=> $this->generateUrl('api_automobiles_show',["id"=>$automobile->getId()],
            Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL)],true );
        // return new JsonResponse("insert bdd OK", 201,["location"=>"api/automobile/".$automobile->getId()
        //],true);
    }

    /**
     * @Route("/api/automobiles/{id}", name="api_automobiles_update", methods={"PUT"})
     */
    public function edit( Automobile $automobile,Request $request,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Automobile::class, 'json', ['object_to_populate' => $automobile]);
        $manager->persist($automobile);
        $manager->flush();

        return new JsonResponse("Update OK", 200, [], true);
    }

    /**
     * @Route("/api/automobiles/{id}", name="api_automobiles_delete", methods={"DELETE"})
     */
    public function delete( Automobile $automobile,ObjectManager $manager )
    {
        $manager->remove($automobile);
        $manager->flush();

        return new JsonResponse("Delete OK", 200, []);


    }

}