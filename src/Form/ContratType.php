<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class ContratType extends AbstractType
{
    public function __construct(VoitureRepository $voitureRepository){
        $this->voitureRepository=$voitureRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datedepart',DateTimeType::class)
            ->add('dateretour',DateTimeType::class)
            ->add('voiture',EntityType::class,[
                'class'=>Voiture::class,
                'choice_label'=> 'matricule',
                'choices'=>$this->voitureRepository->findByAVailibility(),
                'multiple'=>false,
                'expanded'=>false
            ])
        ;
    }






    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
