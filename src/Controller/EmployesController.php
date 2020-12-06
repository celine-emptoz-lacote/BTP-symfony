<?php

namespace App\Controller;



use App\Entity\Utilisateurs;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class EmployesController extends Controller
{
    /**
     * @Route("/employes", name="employes")
     */
    public function employes(): Response
    {
        //affichage de tout les employes 
        $employes = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();   
        

        return $this->render("site/employes_show.html.twig",["employes" => $employes]);
    }

    /**
     * @Route("/employes/{id}", name="employe")
     */
    public function ShowEmploye($id): Response
    {
        //affichage d'un employé
        $affichage_employe = $this->getDoctrine()->getRepository(Utilisateurs::class)->find($id);
       
        if (!$affichage_employe){
           throw $this->createNotFoundException("L\'employé $id n exsite pas ");
       }
         //envoie infos et ou template a notre vue
        return $this->render("site/employe_show.html.twig",["employe" => $affichage_employe]);
    }


    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $entityManager,Request $request){
       $user = new Utilisateurs();
        //creation du formulaire
        $form = $this->CreateForm(UtilisateurType::class);

        //recuperation des infos que l'utilisateur a soumis
        $form->handleRequest($request);

        //verification si les champs ne sont pas vide et que le formulaire a bien été soumis
        if ($form->isSubmitted() && $form->isValid()){

            $employe = $form->getData();
           
            //verifiaction si le matricule existe dejas 
            $matricule = $employe->Matricule;
            $info = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
            
            if(!empty($info)){
                for ($i = 0 ; $i< COUNT($info) ; $i++){

                    //     //Si le matricule existe déja
                        if ($matricule == $info[$i]->Matricule){
                            
                            $this->addFlash('erreur', 'Le matricule Existe déja !');
                    
                       }else {
        
                            $entityManager->persist($employe);
        
                            //on enregistre en BDD
                            $entityManager->flush();
                
                            //message success en session
                            $this->addFlash('success', 'Employé enregistré !');
                            
                            //redirection
                            return $this->redirectToRoute("employes");
                         }
        
                        
                     }
            }else{
                $entityManager->persist($employe);
        
                //on enregistre en BDD
                $entityManager->flush();
    
                //message success en session
                $this->addFlash('success', 'Employé enregistré !');
                
                //redirection
                return $this->redirectToRoute("employes");
            }
           

           
         }
        

        return $this->render("site/add_employes.html.twig",["form" => $form->CreateView()]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */

     //injection de l'utilisateur pour que symfony sache de quel utilisateur on parle
     //id == user
    public function Update(Request $request, Utilisateurs $user ){

        
        //creation du form pour la mise a jour avec l'user en param
        $form = $this->CreateForm(UtilisateurType::class,$user);

        //recuperation des infos que l'utilisateur a soumis
        $form->handleRequest($request);
        
        //recuperation de toutes les donnees pour verification du matricule
        $info = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
        var_dump($user->Matricule);
       
        if ($form->isSubmitted() && $form->isValid()){
           
            
                
                        $em = $this->getDoctrine()->getManager();
                        $em->flush();
                       $this->addFlash('success', 'Modifications prises en compte');
                        return $this->redirectToRoute("employes");
                     
                
            }
            
        

        return $this->render("site/update_employes.html.twig", ["form" => $form->CreateView()]);

    
    }
    /**
     * @Route("/delete/{id}", name="delete");
     */

    public function delete(Utilisateurs $user){
        $em= $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Suppression prise en compte');
        return $this->redirectToRoute("employes");
    }

    public function __toString() {
        return $this->name;
    }
 
}
