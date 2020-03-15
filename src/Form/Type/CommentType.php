<?php
namespace  App\Form\Type;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('name',TextType::class,array( 'required' => false,'attr' => array(
                'placeholder' => 'نام : ',
                'class' => 'form-control',

                'value' => $options[0]['name']
            )))
            ->add('nameAdmin',TextType::class,array('required' => true,'attr' => array(
                'placeholder' => 'نام پاسخگو : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['nameAdmin'],

            )))
            ->add('email',TextType::class,array('required' => false,'attr' => array(
                'placeholder' => 'email : ',
                'class' => 'form-control',
                'value' => $options[0]['email'],

            )))
            ->add('displayStatus', CheckboxType::class, array(
                'label'    => 'Show this entry publicly?',
                'data'   =>  $options[0]['displayStatus'],
                'required' => false
            ))
            ->add('subject', CKEditorType::class,  array(
                'config' => array('toolbar' => 'my_toolbar_1'),
                'data'   =>  $options[0]['subject']

            ))
            ->add('answerAdmin', CKEditorType::class,  array(
                'config' => array('toolbar' => 'my_toolbar_1'),
                'data'   =>  $options[0]['answerAdmin']

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
            'data_class' => 'App\Entity\Comment',
            $resolver->setDefaults( [
                'name'          => null,
                'email'         => null,
                'subject'       => null,
                'displayStatus' => null,
                'answerAdmin'   => null,
                'nameAdmin'     => null,
            ] )
        ));
    }
}