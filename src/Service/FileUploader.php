<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    private $targetDirectoryProduct;
    private $targetDirectoryArticle;
    private $targetDirectoryPages;
    private $targetDirectoryImageGallery;
    private $constantname;

    public function __construct($targetDirectoryImageGallery,$targetDirectoryProduct,$constantname,$targetDirectoryArticle,$targetDirectoryPages)
    {
        $this->targetDirectoryProduct   = $targetDirectoryProduct;
        $this->targetDirectoryArticle   = $targetDirectoryArticle;
        $this->targetDirectoryPages     = $targetDirectoryPages;
        $this->targetDirectoryImageGallery = $targetDirectoryImageGallery;
        $this->constantname    = $constantname;
    }

    public function uploadProductPic(UploadedFile $file)
    {
        $fileName = $this->constantname.'-'.random_int(1,1000).'-'.random_int(1,5000).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectoryProduct(), $fileName);

        return $fileName;
    }
    public function uploadMainPics(UploadedFile $file2)
    {
        $fileName2 = $this->constantname.'-'.random_int(1,1000).'-'.random_int(1,5000).'ss.'.$file2->guessExtension();

        $file2->move($this->getTargetDirectoryPages(), $fileName2);

        return $fileName2;
    }
    public function uploadArticlePic(UploadedFile $file)
    {
        $fileName = $this->constantname.'-'.random_int(1,1000).'-'.random_int(1,5000).'.'.$file->guessExtension();
        $file->move($this->getTargetDirectoryArticle(), $fileName);

        return $fileName;
    }
    public function uploadImageGallery(UploadedFile $file)
    {
        $fileName = $this->constantname.'-'.random_int(1,1000).'-'.random_int(1,5000).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectoryImageGallery(), $fileName);

        return $fileName;
    }
    public function getTargetDirectoryProduct()
    {
        return $this->targetDirectoryProduct;
    }
    public function getTargetDirectoryArticle()
    {
        return $this->targetDirectoryArticle;
    }
    public function getTargetDirectoryPages()
    {

        return $this->targetDirectoryPages;
    }
    public function getTargetDirectoryImageGallery()
    {
        return $this->targetDirectoryImageGallery;
    }

    public function getconstantname()
    {
       return $this->constantname;
    }
    public function deleteFile($filePatch)
    {
        $fileDel=  $this->targetDirectoryProduct.'/'.$filePatch;
        if(file_exists($fileDel)) unlink($fileDel);
        return true;
    }
    public function deleteFileArticle($filePatch)
    {
        $fileDel=  $this->targetDirectoryArticle.'/'.$filePatch;
        if(file_exists($fileDel)) unlink($fileDel);
        return true;
    }
    public function deleteFileMainPage($filePatch)
    {
        $fileDel=  $this->getTargetDirectoryPages().'/'.$filePatch;
        if(file_exists($fileDel)) unlink($fileDel);
        return true;
    }

    public function deleteImageGallery($filePatch)
    {
        $fileDel=  $this->getTargetDirectoryImageGallery().'/'.$filePatch;
        if(file_exists($fileDel)) unlink($fileDel);
        return true;
    }


}