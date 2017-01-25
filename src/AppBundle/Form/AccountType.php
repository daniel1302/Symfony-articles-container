<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class, [
                    'label' => 'Nazwa użytkownika',
                    'attr'  => [
                        'placeholder'   => 'Nazwa użytkownika',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('plainPassword', RepeatedType::class, [
                    'type'  => PasswordType::class,
                    'invalid_message'   => 'Hasła muszą do siebie pasować',
                    'first_options'     => [
                        'label' => 'Hasło',
                        'attr'  => [
                            'placeholder'   => 'Hasło',
                            'class'         => 'form-control'
                        ]
                    ],
                    'second_options'    => [
                        'label' => 'Powtórz hasło',
                        'attr'  => [
                            'placeholder'   => 'Powtórz hasło',
                            'class'         => 'form-control'
                        ]
                    ]
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Adres email',
                    'attr'  => [
                        'placeholder'   => 'Adres email',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('firstname', TextType::class, [
                    'label' => 'Imię',
                    'attr'  => [
                        'placeholder'   => 'Imię',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('surname', TextType::class, [
                    'label' => 'Nazwisko',
                    'attr'  => [
                        'placeholder'   => 'Nazwisko',
                        'class'         => 'form-control'
                    ]
                ])
                ->add('address', AddressType::class, [
                    'required' => false,
                    'constraints' => [new Assert\Valid]

                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'            => 'AppBundle\Entity\Account',
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'validation_groups'     => function(\Symfony\Component\Form\FormInterface $form) {
                $data = $form->getData();

                if (!empty($data->getId()) && empty($data->getPlainPassword())) {
                    return ['Default'];
                } else {
                    return ['Default', 'Strict'];
                }
            }
        ]);
    }
}
