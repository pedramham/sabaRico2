<?php

namespace App\Form\Type;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
class CategoryArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('name',TextType::class,array('attr' => array(
                'placeholder' => 'نام : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['name']
            )))
            ->add('title',TextType::class,array('attr' => array(
                'placeholder' => 'عنوان : ',
                'class' => 'form-control',
                'value' => $options[0]['title'],
                'required' => false,
            )))
            ->add('smallPic', FileType::class, array(
                'label' => "smallpic",
                'required' => false
            ))
            ->add('largePic',FileType::class, array(
                'label' => "largePic",
                'required' => false,

            ))

            ->add('displayStatus', CheckboxType::class, array(
                'label'    => 'Show this entry publicly?',
                'data'   =>  $options[0]['displayStatus'],
                'required' => false
            ))
            ->add('descriptionSeo', CKEditorType::class,  array(
                'config' => array('toolbar' => 'my_toolbar_1'),
                'data'   =>  $options[0]['descriptionSeo']

            ))
            ->add('subject', CKEditorType::class,  array(
                'config' => array('toolbar' => 'my_toolbar_1'),
                'data'   =>  $options[0]['subject']

            ))

            ->add('description',  CKEditorType::class,  array(
                'data'   =>  $options[0]['description'],
                'config' => array(
                    'toolbar' => 'my_toolbar_2',
                    'extraAllowedContent' => "amp-img[!src,!width,!height,!layout,!title,!alt];b;h1;h2;h3;h4;h5;h6;strong;",

                    'allowedContent' => "true",


                ),
            ))
            ->add('labelKeyWord',TextType::class,array('attr' => array(
                'placeholder' => 'کلمات کلیدی : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['labelKeyWord']
            )))
            ->add('urlSlug',TextType::class,array('attr' => array(
                'placeholder' => ' آدرس اینترتی : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['urlSlug']
            )))
            ->add('panelMainPageTopArticle',NumberType::class,array('attr' => array(
                'placeholder' => ' اولویت نمایش در پنل صفحه بالا  : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['panelMainPageTopArticle']
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
            'data_class' => 'App\Entity\CategoryArticle',
            $resolver->setDefaults( [
                'name'            => null,
                'title'           => null,
                'subject'         => null,
                'description'     => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'largePic'         => null,
                'labelKeyWord'    => null,
                'urlSlug'         => null,
                'displayStatus'   => null,
                'panelMainPageTopArticle' => null,

            ] )
        ));
    }
}