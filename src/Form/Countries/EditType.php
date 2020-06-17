<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:58
 */

namespace App\Form\Countries;


use App\Entity\Languages\Language;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Nazwa'
            ])
            ->add('flag', FileType::class, [
                'attr' => [
                    'class' => 'form-control-file'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Flaga'
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('l')
                        ->orderBy('l.name', 'ASC');
                },
                'choice_label' => function (Language $language) {
                    return $language->getName();
                },
                'choice_value' => function(?Language $language) {
                    return $language?$language->getName():'';
                },
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'multiple' => true,
                'label' => 'Język urzędowy (z uwzględnieniem możliwości, że jest ich kilka)'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'row_attr' => [
                    'class' => 'text-center'
                ],
                'label' => 'Zmień'
            ])
        ;
        $builder->get('languages')->resetViewTransformers();
        $builder->get('languages')->resetModelTransformers();
    }
}