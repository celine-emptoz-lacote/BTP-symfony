<?php

namespace App\Form;

use App\Entity\Chantiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChantiersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class ,[ "attr" => ['class' => "form-control"]])
            ->add('Adresse', TextType::class ,[ "attr" => ['class' => "form-control"]])
            ->add('Date_de_debut',DateType::class, [
               
                'format' => 'dd-M-yyyy'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chantiers::class,
        ]);
    }
}
