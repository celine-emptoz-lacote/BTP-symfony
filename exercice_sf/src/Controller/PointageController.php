<?php

namespace App\Controller;

use DateTime;
use App\Entity\Heures;
use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Form\PointageType;
use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PointageController extends AbstractController
{
    /**
     * @Route("/pointages", name="pointages")
     */
    public function pointages(): Response
    {
        $repo =  $this->getDoctrine()->getRepository(Pointages::class)->findall();
        
        $recup = $this->getDoctrine()->getRepository(Pointages::class)->Innerjoin();
        
        
         if (empty($repo)){
             return $this->render('site/pointages.html.twig', [
                 'controller_name' => 'page de pointage',
                 "infos" => "Aucune donnée !"]);
         }
         else{
             return $this->render('site/pointages.html.twig', [
                 'controller_name' => 'page Pointage',
                 "infos" => $repo,
                 "donnees" => $recup
                 
             ]);
         }
    }

    /**
     * @Route("/add_pointage", name="add_pointage")
     */
    public function add_pointage(EntityManagerInterface $entityManager,Request $request ) : Response
    {
        $new_pointage = new Pointages();
        $form = $this->CreateForm(PointageType::class);

        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()){
           
            
            
            $pointage = $form->getData();
            

            //On recupere l'id de l'employé du formulaire 
            $id = $pointage->utilisateurs->id;
            
            
            //recuperation du numero de semaine par rapport au jour selectionner
            $date_du_jour = $pointage->date_debut->format('Y-m-d');
            $good_format=strtotime ($date_du_jour);
            $semaine = date('W',$good_format) ;
            

            //recuperation de tout les jours pointés de cet employé 
            $donnees = $this->getDoctrine()->GetRepository(Pointages::class)->recupDonnee($id);
           
            if (!empty($donnees)){
                //on boucle sur le tableau de resultat pour verifier si le jour selectionné n'est pas deja travaillé
                for ($i = 0 ; $i < COUNT($donnees) ; $i++){
                    
                    //si le jour selectionner est deja travailler
                    if ($pointage->date_debut->format("Y-m-d") != $donnees[$i]->date_debut->format("Y-m-d") ){
                        

                        //On recupere le nombre d heures effectuer das la semaine courante
                        $nbre_heures = $this->getDoctrine()->GetRepository(Heures::class)->recupHeures($semaine,$id);
                      

                        //si pas d heures travailler
                        if (isset($nbre_heures)){
                            
                            //Verification du compteur d'heure
                            if ($nbre_heures[0]['heure'] <= 28 ){
                                
                                $bool = true;
                            }else{
                                
                                $bool = false;
                               
                                return $this->render('site/add_pointage.html.twig', [ 
                                    'controller_name' => 'Page de pointage des salariés ',
                                    'infos'=> 'Cet employé a deja atteind 35 heures !',
                                    'controller_name' => 'Page de pointage des salariés ',
                                    'form' => $form->CreateView() ]);
                            }
                        }else{
                            $bool = true;
                        }
                    }else{
                        
                        $bool = false;
                        
                        return $this->render('site/add_pointage.html.twig', [ 
                            'controller_name' => 'Page de pointage des salariés ',
                            'infos'=> 'Jour deja travaillé !',
                            'controller_name' => 'Page de pointage des salariés ',
                            'form' => $form->CreateView() ]);
                        
                        
                    }
                    
                    
                }
            }else {
                $bool = true;
            }
            

            //enregistrement
            if ($bool==true){
                $entityManager->persist($pointage);
                $id = $pointage->utilisateurs->id;
                        
                        
                //on enregistre en bdd
                $heure = new Heures();
                $heure->setSemaine($semaine);
                $heure->setCompteur(7);
                $heure->setIdUser($id);
                
                $entityManager->persist($heure);

                $entityManager->flush();
              
                return $this->redirectToRoute("pointages");
            }
        }
        

        return $this->render('site/add_pointage.html.twig', [ 
            'controller_name' => 'Page de pointage des salariés ',
            'form' => $form->CreateView() ]);
    }

    /**
     * @Route("/delete_pointage/{id}", name="delete_pointage")
     */
    public function delete_pointage(Pointages $pointage){
        $em= $this->getDoctrine()->getManager();
        $em->remove($pointage);
        $em->flush();
        return $this->redirectToRoute("pointages");
    }
}
