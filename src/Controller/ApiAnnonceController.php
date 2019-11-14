<?php

namespace App\Controller;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Annonce;



class ApiAnnonceController extends AbstractController
{
    /**
 * @Route("/api/annonces", name="api_annonces", methods={"GET"})
 */
    public function show(AnnonceRepository $repo, SerializerInterface $serializer )
    {
        $annonces= $repo->findAll();
        $resultat=$serializer->serialize(
            $annonces,
            'json',
            [
                'groups'=>['listAnnonceFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/annonces/{id}", name="api_annonces_show", methods={"GET"})
     */
    public function list( Annonce $annonce, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $annonce,
            'json',
            [
                'groups'=>['listAnnonceFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/annonces", name="api_annonces_create", methods={"POST"})
     */
    public function create(Request $request ,ObjectManager $manager, SerializerInterface $serializer , ValidatorInterface $validator )
    {
        $data=$request->getContent();
        //$annonce=new Annonce();
        //$serializer->deserialize($data, Annonce::class,'json',['object_to_populate'=>$annonce]);
        $annonce=$serializer->deserialize($data, Annonce::class,'json');
        //Gestion Errors Validation
        $errors=$validator->validate($annonce);
        if(count($errors)){
            $errorsJson=$serializer->serialize($errors,'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }
        $manager->persist($annonce);
        $manager->flush();
        // Generate URL Absolute
        return new JsonResponse(
            "Insertion ok",Response::HTTP_CREATED,["location"=> $this->generateUrl('api_annonces_show',["id"=>$annonce->getId()],
            Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL)],true );
        // return new JsonResponse("insert bdd OK", 201,["location"=>"api/annonces/".$annonce->getId()
        //],true);
    }

    /**
     * @Route("/api/annonces/{id}", name="api_annonces_update", methods={"PUT"})
     */
    public function edit( Annonce $annonce,Request $request,ObjectManager $manager, SerializerInterface $serializer,ValidatorInterface $validator )
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Annonce::class, 'json', ['object_to_populate' => $annonce]);
        //Gestion Errors Validation
        $errors=$validator->validate($annonce);
        if(count($errors)){
            $errorsJson=$serializer->serialize($errors,'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }
        $manager->persist($annonce);
        $manager->flush();

        return new JsonResponse("Update OK", 200, [], true);
    }

    /**
     * @Route("/api/annonces/{id}", name="api_annonces_delete", methods={"DELETE"})
     */
    public function delete( Annonce $annonce,ObjectManager $manager )
    {
        $manager->remove($annonce);
        $manager->flush();

        return new JsonResponse("Delete OK", 200, []);


    }

    }
