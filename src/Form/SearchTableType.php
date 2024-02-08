<?php

namespace App\Form;

use App\Repository\TableRepository;
use Symfony\Component\Form\AbstractType;
use App\Entity\ValueObject\SearchTableQuery;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchTableType extends AbstractType
{
    public function __construct(
        private readonly TableRepository $tableRepository
    )
    {
        
    }
    private function defineOwnerChoices():array
    {   
        $owners = $this->tableRepository
                ->createQueryBuilder('t')
                ->select('t.owner')
                ->groupBy('t.owner')
                ->where('t.owner is not NULL')
                ->getQuery()
                ->getResult();
        $choices = [];
        foreach($owners as $owner){
            $value = $owner["owner"];
            $choices[$value] =  $value;
        }
        return $choices;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('owners',ChoiceType::class,[
                'label'=>'Référentiel',
                'choices'=>$this->defineOwnerChoices(),
                'multiple'=>true,
                'required'=>false,
                'autocomplete'=>true
            ])
            ->add('user_query',null,[
                'label'=>'Recherche'
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Rechercher'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>SearchTableQuery::class
        ]);
    }
}
