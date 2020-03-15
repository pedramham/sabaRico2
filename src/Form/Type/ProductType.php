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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class ProductType extends AbstractType
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
            ->add('idCategoryProduct', EntityType::class,array(
                'data'   =>  $options[0]['idCategoryProduct'],
                'class' => 'App:CategoryProduct',
                'choice_label' => 'name',
                'attr' => array(
                    'label'    => 'فهرست ',
                    'class' => 'form-control'
                )
            ))
            ->add('price',IntegerType::class,array('attr' => array(
                'placeholder' => 'قیمت : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['price']
            )))
            ->add('discount',IntegerType::class,array('attr' => array(
                'placeholder' => 'تخفیف : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['discount']
            )))
            ->add('manufacturingCountry',TextType::class,array('attr' => array(
                'placeholder' => ' کشور سازنده : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['manufacturingCountry']
            )))
            ->add('brand',TextType::class,array('attr' => array(
                'placeholder' => ' نام برند : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['brand']
            )))
            ->add('guarantee',TextType::class,array('attr' => array(
                'placeholder' => ' گارانتی : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['guarantee']
            )))

            ->add('periodGuarantee', DateType::class, [
                'attr' => array(
                    'placeholder' => 'مدت گارانتی : ',
                    'class' => 'form-control directionRtl form-control-sm ',
                ),
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy',
                'data'   =>  $options[0]['periodGuarantee'],

            ])
            ->add('sellerTelephone',TextType::class,array('attr' => array(
                'placeholder' => ' تلفن فروشنده  : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['sellerTelephone']
            )))

            ->add('productCode',TextType::class,array('attr' => array(
                'placeholder' => ' کد محصول  : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['productCode']
            )))
            ->add('companyImporter',TextType::class,array('attr' => array(
                'placeholder' => ' شرکت وارد کننده: ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['companyImporter']
            )))

            ->add('panelLastProduct',NumberType::class,array('attr' => array(
                'placeholder' => ' اولویت نمایش در پنل آخرین محصولات : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['panelLastProduct']
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
            'data_class' => 'App\Entity\Product',
            $resolver->setDefaults( [
                'name'            => null,
                'title'           => null,
                'subject'         => null,
                'description'     => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'labelKeyWord'    => null,
                'urlSlug'         => null,
                'displayStatus'   => null,
                'idCategoryProduct' => null,
                'price'             => null,
                'discount'          => null,
                'manufacturingCountry' => null,
                'brand'             => null,
                'guarantee'         => null,
                'periodGuarantee'   => null,
                'sellerTelephone'   => null,
                'panelLastProduct'  => null,
                'productCode'       => null,
                'companyImporter'   => null,

            ] )
        ));
    }
}