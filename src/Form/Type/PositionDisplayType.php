<?php
namespace  App\Form\Type;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PositionDisplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('panelMainPageTopArticle', CheckboxType::class, array(
                'label'    => 'Show this entry publicly?',
                'data'   =>  $options[0]['panelMainPageTopArticle'],
                'required' => false
            ))
            ->add('pPanelMainPageTopArticle',NumberType::class,array('required' => false,'attr' => array(
                'placeholder' => ' اولویت نمایش : ',
                'class' => 'form-control',
                'value' => $options[0]['pPanelMainPageTopArticle']
            )))

            ->add('panelMostViewNews', CheckboxType::class, array(
                'label'    => 'Show this entry publicly?',
                'data'   =>  $options[0]['panelMostViewNews'],
                'required' => false
            ))

            ->add('ppanelMostViewNews',NumberType::class,array('required' => false,'attr' => array(
                'placeholder' => ' اولویت نمایش : ',
                'class' => 'form-control',
                'value' => $options[0]['ppanelMostViewNews']
            )))


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
            'data_class' => 'App\Entity\PositionDisplay',
            $resolver->setDefaults( [
                'panelMostViewNews'   => null,
                'ppanelMostViewNews'  => null,
                'panelMainPageTopArticle'  => null,
                'pPanelMainPageTopArticle' => null,
            ] )
        ));
    }
}