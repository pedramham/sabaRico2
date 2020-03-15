<?php

namespace App\Form\Type;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
class CategoryVideoType extends AbstractType
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
            ->add('codeColorBrand',TextType::class,array('attr' => array(
                'placeholder' => 'کد رنگ : ',
                'class' => 'form-control',
                'value' => $options[0]['codeColorBrand'],
                'required' => false,
            )))
            ->add('smallPic', FileType::class, array(
                'label' => "smallPic",
                'required' => false
            ))
            ->add('largePic', FileType::class, array(
                'label' => "largePic",
                'required' => false
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
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => array(
                        'instance' => 'default',
                        'homeFolder' => ''
                    )

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
            ->add('authorName',TextType::class,array('attr' => array(
                'placeholder' => ' نام نویسنده : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['authorName']
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
            'data_class' => 'App\Entity\CategoryVideo',
            $resolver->setDefaults( [
                'name'            => null,
                'title'           => null,
                'subject'         => null,
                'description'     => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'labelKeyWord'    => null,
                'urlSlug'         => null,
                'authorName'      => null,
                'displayStatus'   => null,
                'largePic'       => null,
                'codeColorBrand'  => null,
            ] )
        ));
    }
}