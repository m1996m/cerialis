<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/api/produit", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->json($produitRepository->findAll(),200);
    }

    /**
     * @Route("/produit/new", name="produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $content=$request->getContent();
        $form=json_decode($content,true);
        $produit->setDesignation($form['designation']);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $reference=substr(str_shuffle($chars),0,12);
        $produit->setReference($reference);
        $produit->setImage($form['image']);
        $entityManager->persist($produit);
        $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/api/search", name="search_index", methods={"GET"})
     */
    public function search(ProduitRepository $produitRepository,Request $request): Response
    {
        $content=$request->getContent();
        $form=json_decode($content,true);
        return $this->json($produitRepository->getSearch($form['content']),200);
    }

    /**
     * @Route("/api/getProduit/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->json($produit,200);
    }

    /**
     * @Route("/api/getEditProduit/{id}", name="produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $content=$request->getContent();
        $form=json_decode($content,true);
        $produit->setDesignation($form['designation']);
        $produit->setReference($form['reference']);
        $produit->setImage($form['image']);
        $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
