<?php

namespace Backlog\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use Backlog\AppBundle\Entity\User;

class RegisterType extends AbstractType
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $encoderFactory = $this->encoderFactory;

        $builder
            ->add('username', 'text')
            ->add('fullname', 'text')
            ->add('initials', 'text')
            ->add('email', 'text')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'mapped' => false,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat password'),
            ))
            ->addEventListener(FormEvents::BIND, function (FormEvent $event) use ($encoderFactory) {
                $user = $event->getData();
                if (!$user instanceof User) {
                    throw new \RuntimeException('Data for registration form should be a user');
                }

                $password = $event->getForm()->get('password')->getData();
                if (null === $password) {
                    return;
                }

                $user->setPassword($password, $encoderFactory->getEncoder($user));
            });
        ;
    }

    public function getOptions()
    {

    }

    public function getName()
    {
        return 'bl_register';
    }
}
