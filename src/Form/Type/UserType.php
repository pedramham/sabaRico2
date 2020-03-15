<?php
namespace App\Form\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name',TextType::class,array('required' => true,'attr' => array(
                'placeholder' => 'نام : ',
                'class' => 'form-control',
                'value' => $options[0]['name']
            )))
            ->add('family',TextType::class,array('required' => false,'attr' => array(
                'placeholder' => 'نام خانوادگی : ',
                'class' => 'form-control',
                'value' => $options[0]['family'],
            )))
            ->add('email',TextType::class,array('required' => true,'attr' => array(
                'placeholder' => 'ایمیل  : ',
                'class' => 'form-control',
                'value' => $options[0]['email'],
            )))
            ->add('username',TextType::class,array('required' => true,'attr' => array(
                'placeholder' => 'نام کاربری  : ',
                'class' => 'form-control',
                'value' => $options[0]['username'],
            )))

            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'first_options'  => array('label' => 'رمز عبور','attr' => array(
                'placeholder' => ' رمز عبور : ',
                    'value' => $options[0]['password'],
                'class' => 'form-control',

                )),
                'second_options' => array('label' => 'تکرار رمز عبور',
                    'attr' => array(
                        'required' => false,
                        'value' => $options[0]['password'],
                    'placeholder' => '  تکرار رمز عبور : ',
                    'class' => 'form-control',
                    'required' => false
                )),
            ))
            ->add('address',TextType::class,array('label' => 'تکرار رمز عبور','attr' => array(
                'placeholder' => 'آدرس   : ',
                'class' => 'form-control',
                'value' => $options[0]['address'],
            )))
            ->add('telephon',TextType::class,array('attr' => array(
                'placeholder' => 'تلفن   : ',
                'class' => 'form-control',
                'value' => $options[0]['telephon'],
                'required' => false,
            )))
            ->add('mobile',TextType::class,array('attr' => array(
                'placeholder' => 'موبایل   : ',
                'class' => 'form-control',
                'value' => $options[0]['mobile'],
                'required' => false,
            )))

            ->add('picUser', FileType::class, array(
                'label' => "picUser",
                'required' => false
            ))

            ->add('subject', CKEditorType::class,  array(
                'config' => array(
                    'toolbar' => 'my_toolbar_2',
                    'filebrowserBrowseRoute'           => 'elfinder',
                    'filebrowserBrowseRouteParameters' => array('slug' => 'my-slug'),
                    'filebrowserBrowseRouteType'       => UrlGeneratorInterface::ABSOLUTE_URL,
                ),
                'data'   =>  $options[0]['subject']

            ))
            ->add('roles', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'required' => false,
                ),
                'multiple' => true,
                'expanded' => true, // render check-boxes
                'choices' => [
                    'آدمین' => 'ROLE_ADMIN',
                    'کاربری' => 'ROLE_USER',
                ]
            ))
            ->add('save', SubmitType::class, array(
                'attr'=>array(
                    'class'=>'btn btn-primary',
                    'onclick' => 'this.form.submit(); this.disabled = true; this.value = \'Submitting the form\';'
                ),
                'label' => 'ارسال '
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User',
            $resolver->setDefaults( [
                'name'     => null,
                'family'   => null,
                'email'    => null,
                'username' => null,
                'password' => null,
                'address'  => null,
                'telephon' => null,
                'mobile'   => null,
                'subject'   => null,
                'picUser'  => null,
                'roles'  => null,
            ] )
        ));
    }
}
