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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class ArticleType extends AbstractType
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
            ->add('labelKeyWord',TextType::class,array('attr' => array(
                'placeholder' => 'کلمات کلیدی : ',
                'class' => 'form-control',
                'value' => $options[0]['labelKeyWord'],
                'required' => false,
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
            ->add('descriptionSeo', CKEditorType::class,  array(
                'config' => array('toolbar' => 'my_toolbar_1'),
                'data'   =>  $options[0]['descriptionSeo']

            ))

            ->add('description',  CKEditorType::class,  array(
                'data'   =>  $options[0]['description'],
                'config' => array(
                    'toolbar' => 'my_toolbar_2',
                    'extraAllowedContent' => "p;b;h1;h2;h3;h4;h5;h6;strong;a[!href,title];
                                              amp-instagram[!data-shortcode,!data-captioned,!width,!height,!layout];
                                              amp-carousel[!height,!layout,!type,!lightbox,!id,];amp-img[src,width,height,layout,title,alt]",
                    'allowedContent' => "true",
                ),
            ))
            ->add('idCategory', EntityType::class,array(
                'data'   =>  $options[0]['idCategory'],
                'class' => 'App:CategoryArticle',
                'choice_label' => 'name',
                'attr' => array(
                    'label'    => 'فهرست ',
                    'class' => 'form-control'
                )
            ))
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
            ->add('panelMainPageTopArticle',NumberType::class,array('attr' => array(
                'placeholder' => ' اولویت نمایش در پنل صفحه بالا  : ',
                'class' => 'form-control',
                'required' => false,
                'value' => $options[0]['panelMainPageTopArticle']
            )))
            ->add('save', SubmitType::class, array(
                'attr'=>array(
                    'class'=>'btn btn-primary',
//                    'onclick' => 'this.form.submit(); this.disabled = true; this.value = \'Submitting the form\';'
                ),
                'label' => 'ارسال '
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Article',
            $resolver->setDefaults( [
                'name'           => null,
                'title'          => null,
                'subject'        => null,
                'description'    => null,
                'descriptionSeo' => null,
                'smallPic'       => null,
                'largePic'       => null,
                'idCategory'     => null,
                'labelKeyWord'   => null,
                'urlSlug'        => null,
                'authorName'     => null,
                'displayStatus'  => null,
                'panelMainPageTopArticle' => null,
            ] )
        ));
    }
}