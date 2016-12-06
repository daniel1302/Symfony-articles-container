<?php 
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Model\Voivodeship;

class AddressType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('street', TextType::class, [             
                    'label' => 'Ulica',
                    'attr'  => [
                        'placeholder' => 'Ulica',
                        'class'       => 'form-control'
                    ]
                ])
                ->add('postcode', TextType::class, [
                    'label' => 'Kod pocztowy',
                    'attr'  => [
                        'placeholder'   => 'Kod pocztowy',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('city', TextType::class, [
                    'label' => 'Miasto',
                    'attr'  => [
                        'placeholder'   => 'Miasto',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('voivodeship', ChoiceType::class, [
                    'choices'   => array_flip(Voivodeship::$names),
                    'attr'      => [
                        'placeholder'   => 'Województwo',
                        'class'         => 'form-control'
                    ]
                ])
                ;
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults([
            'data_class'    => 'AppBundle\Entity\Address'
        ]);
    }
}
