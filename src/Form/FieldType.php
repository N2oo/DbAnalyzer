<?php

namespace App\Form;

use App\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\FieldRepository;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('length')
            ->add('forTable')
            ->add('type')
            ->add('useProperty',null,[
                'query_builder' => function (FieldRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->leftjoin('f.forTable', 't')
                        ->addOrderBy('t.name','ASC')
                        ->addOrderBy('f.name','ASC');
                },
            ])
            ->add('isPrimary')
            ->add('field_original_id')
            ->add('commentary')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
        ]);
    }
}
