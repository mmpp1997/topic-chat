<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array(
                    'class' => 'room-add',
                    'placeholder' => 'Enter room name...'
                ),
                'label' => false,
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'attr' => array(
                    'class' => 'room-add',
                    'placeholder' => 'Enter room description...'
                ),
                'label' => false,
                'required' => true
            ])
            ->add('imgSource', TextType::class, [
                'attr' => array(
                    'class' => 'room-add',
                    'placeholder' => 'Enter source...'
                ),
                'label' => false,
                'required' => true
            ])
            //->add('owner')
            //->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
