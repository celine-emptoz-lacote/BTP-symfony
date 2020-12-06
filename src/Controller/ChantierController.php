<?php

namespace App\Controller;

use App\Entity\Chantiers;
use App\Form\ChantiersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChantierController extends AbstractController
{
    /**
     * @Route("/chantiers", name="chantiers")
     */
    public function chantiers(): Response
    {
        
        $chantiers = $this->getDoctrine()->getRepository(Chantiers::class)->findAll();
        
       
      // $date = date_format($chantiers[0]->Date_de_debut, 'd-m-Y');
        return $this->render('site/chantiers.html.twig', [
            'controller_name' => 'ChantierController',
            'chantiers' => $chantiers
          
        ]);
    }

    /**
     * @Route("/add_chantier", name="add_chantier")
     */
    public function add_chantier(Request $request){
        $chantier = new Chantiers();

        //creation du form
        $form = $this->CreateForm(ChantiersType::class);

        //recuperation des infos que l'utilisateur a soumis
        $form->handleRequest($request);
        
        //verfiaction
        if ( $form->isSubmitted() && $form->isValid()){
             $em = $this->getDoctrine()->getManager();
            $donnees = $form->getData();
             $em->persist($donnees);
             $em->flush();
             $this->addFlash('success', 'Chantier enregistreé !');
             //redirection
             return $this->redirectToRoute("chantiers");
        }

        //envois a la vue
        return $this->render("site/add_chantiers.html.twig",["form"=>$form->CreateView()]);
    }

    /**
     * @Route("/show/{id}" , name="show_chantier")
     */

     public function show_chantier(Request $request,Chantiers $chantier){
        $chantier = $this->getDoctrine()->getRepository(Chantiers::class)->find($chantier);
        $date = date_format($chantier->Date_de_debut, 'd-m-Y');
        return $this->render('site/chantier_show.html.twig', ["chantier"=>$chantier,
                                                       "controller_name" =>$chantier->Nom,
                                                       "date"=>$date]);

     }

    /**
     * @Route("/edit/{id}" , name="edit")
     */
    public function edit(Request $request,Chantiers $chantier){
        
        //creation du form
        $form = $this->CreateForm(ChantiersType::class,$chantier);

        //recuperation des infos que l'utilisateur a soumis
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            //$donnees = $form->getData();
           
            $em->flush();
            $this->addFlash('success', 'Chantier Modifié !');
            //redirection
            return $this->redirectToRoute("show_chantier", ["id"=>$chantier->getId()]);
       }

       //envois a la vue
       return $this->render("site/edit_chantiers.html.twig",["form"=>$form->CreateView()]);
        

    }

    /**
     * @Route("/delete_chantier/{id}" , name="delete_chantier")
     */
    public function delete_chantier(Chantiers $chantier){
        $em = $this->getDoctrine()->getManager();
        $em->remove($chantier);
        $em->flush();
        $this->addFlash('success', 'Chantier supprimé !');
        //redirection
        return $this->redirectToRoute("chantiers");
    }
}
