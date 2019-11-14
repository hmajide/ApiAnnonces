<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Categories;


class ApiCategoriesController extends AbstractController
{
    /**
     * @Route("/api/categories", name="api_categories", methods={"GET"})
     */
    public function show(CategoriesRepository $repo, SerializerInterface $serializer )
    {
        $immobilers= $repo->findAll();
        $resultat=$serializer->serialize(
            $immobilers,
            'json',
            [
                'groups'=>['listCategoriesFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/categories/{id}", name="api_categories_show", methods={"GET"})
     */
    public function list( Categories $categories, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $categories,
            'json',
            [
                'groups'=>['listCategoriesFull']
            ]
        );
        return new JsonResponse($resultat, 200,[],true);
    }

    /**
     * @Route("/api/categories", name="api_categories_create", methods={"POST"})
     */
    public function create(Request $request ,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data=$request->getContent();
        //$categories =new Categories();
        //$serializer->deserialize($data, Categories::class,'json',['object_to_populate'=>$categories]);
        $categories=$serializer->deserialize($data, Categories::class,'json');
        $manager->persist($categories);
        $manager->flush();
        // Generate URL Absolute
        return new JsonResponse(
            "Insertion ok",Response::HTTP_CREATED,["location"=> $this->generateUrl('api_categories_show',["id"=>$categories->getId()],
            Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL)],true );
        // return new JsonResponse("insert bdd OK", 201,["location"=>"api/categories/".$categories->getId()
        //],true);
    }

    /**
     * @Route("/api/categories/{id}", name="api_categories_update", methods={"PUT"})
     */
    public function edit( Categories $categories,Request $request,ObjectManager $manager, SerializerInterface $serializer )
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Categories::class, 'json', ['object_to_populate' => $categories]);
        $manager->persist($categories);
        $manager->flush();

        return new JsonResponse("Update OK", 200, [], true);
    }

    /**
     * @Route("/api/categories/{id}", name="api_categories_delete", methods={"DELETE"})
     */
    public function delete( Categories $categories,ObjectManager $manager )
    {
        $manager->remove($categories);
        $manager->flush();

        return new JsonResponse("Delete OK", 200, []);


    }

}