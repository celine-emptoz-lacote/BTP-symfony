<?php

namespace App\Form;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


   
        $builder
            ->add('date_debut')
            //on recupere les infos de la table chantiers grace a entityType => recuperation des noms
            ->add('chantiers', EntityType::class, [ 'class'=>Chantiers::class,
            'choice_label' => 'nom'] )
            ->add('utilisateurs',EntityType::class, [ 'class'=>Utilisateurs::class,
            'choice_label' => 'nom']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointages::class,
        ]);
    }
}
