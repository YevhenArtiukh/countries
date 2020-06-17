<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:31
 */

namespace App\Form\Users;


use App\Entity\Countries\Country;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AddCountriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countries', EntityType::class, [
                'class' => Country::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->where('c.active = TRUE')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => function (Country $country) {
                    return $country->getName();
                },
                'multiple' => true,
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Wybierz w których krajach byłeś'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'row_attr' => [
                    'class' => 'text-center'
                ],
                'label' => 'Zapisz'
            ])
            ;
    }
}