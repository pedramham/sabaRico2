<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryNewsType;
use App\Entity\CategoryNews;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryNewsController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryNews",name="indexCategoryNews")
     */
    public function indexCategoryNewsAction()
    {
        return $this->render('AdminPanel/CategoryNews/index_category_news.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryNews",name="newCategoryNews")
     */
    public function newCategoryNewsAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryNews = new CategoryNews();
        $form = $this->createForm(CategoryNewsType::class,$CategoryNews ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryNews'),
            [
                'name'        => null,
                'title'       => null,
                'subject'     => null,
                'description' => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'largPic'         => null,
                'urlSlug'         => null,
                'labelKeyWord'    => null,
                'displayStatus'   => null,
                'panelNewsCategory' => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryNews->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $CategoryNews->setSmallPic($smallPic);

            ////////////largPic///////////
            $fileLargPic = $CategoryNews->getLargPic();
            $largPic = $fileUploader->uploadArticlePic($fileLargPic);
            $CategoryNews->setLargPic($largPic);
            ///////////////////////////

            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->persist($data);
            $em->flush();
            $this->addFlash(
                'success',
                'فهرست جدید اضافه شد'
            );
            return $this->redirectToRoute('listCategoryNews');
        }
        return $this->render('AdminPanel/CategoryNews/new_category_news.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryNews/{id}",name="editCategoryNews")
     */
    public function editCategoryNewsAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryNews');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryNews = new CategoryNews();
        $form = $this->createForm(CategoryNewsType::class,$CategoryNews,array(
            'action' => $this->generateUrl('editCategoryNews',array('id' => $categoryData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'          => $categoryData->getName(),
                'title'         => $categoryData->getTitle(),
                'subject'       => $categoryData->getSubject(),
                'description'   => $categoryData->getDescription(),
                'descriptionSeo'  => $categoryData->getDescriptionSeo(),
                'smallPic'        => $categoryData->getSmallPic(),
                'largPic'         => $categoryData->getLargPic(),
                'labelKeyWord'    => $categoryData->getLabelKeyWord(),
                'urlSlug'         => $categoryData->getUrlSlug(),
                'displayStatus'   => $categoryData->getDisplayStatus(),
                'panelNewsCategory' => $categoryData->getPanelNewsCategory(),
            ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
            $categoryData->setName($form->get('name')->getData());
            $categoryData->setTitle($form->get('title')->getData());
            $categoryData->setSubject($form->get('subject')->getData());
            $categoryData->setDescription($form->get('description')->getData());
            $categoryData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $categoryData->setDisplayStatus($form->get('displayStatus')->getData());
            $categoryData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $categoryData->setUrlSlug($form->get('urlSlug')->getData());
            $categoryData->setPanelNewsCategory($form->get('panelNewsCategory')->getData());

            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $categoryData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $categoryData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largPic')->getData() != ""){
                $filePatchLargPic = $categoryData->getLargPic();
                $fileUploader->deleteFileArticle($filePatchLargPic);
                $file = $form->get('largPic')->getData();
                $largPic = $fileUploader->uploadArticlePic($file);
                $categoryData->setLargPic($largPic);
            }
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listCategoryNews');

        }
        return $this->render('AdminPanel/CategoryNews/edit_category_news.html.twig', array(
            'form' => $form->createView(),
            'CategoryNews' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryNews",name="listCategoryNews")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryNews');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryNews/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteCategoryNews/{id}",name="deleteCategoryNews")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryNews');
        $category = $categoryRe->find($id);

        ////////NewsCHeck/////////////
        $repositoryNews = $this->getDoctrine()
            ->getRepository('App:News');
        $queryNews=   $repositoryNews->createQueryBuilder('n')
            ->Where('n.idCategory = :idCategory')
            ->setParameter('idCategory',$id)
            ->getQuery();
        $NewsRelate = $queryNews->getResult();
        if ($NewsRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای مقاله است لطفا ابتدا مقالات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryNews');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Article Found for id : ",$id);
        }
        $filePatch2 = $category->getLargPic();
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFileArticle($filePatch2);
        $fileUploader->deleteFileArticle($filePatch);
        $em->remove($category);
        ///delete Cache redis
        $this->deleteCacheAfterChangeDataBase($em);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listCategoryNews');
    }

    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('News××−by−××id×1');
        $cacheDriver->delete('News××−by−××Limit××2');
        $cacheDriver->delete('News××−by−××relate×××3');
        $cacheDriver->delete('category××××news−×××−−×1');

    }
}
