<?php
namespace App\Controller\AdminPanel;
use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\FileUploader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserController extends AbstractController
{
    public $key;
    /**
     * @Route("/admin_Cp/userIndex",name="AdminUserIndex")
     */
    public function index()
    {
        return $this->render('AdminPanel/User/index.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/panel/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('AdminPanel/User/login_user.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/admin_Cp/ListUser",name="ListUser")
     */
    public function ListUser()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:User');

        $User =  $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
//$eer= implode("",$User);
        //  var_export($User[0]);
        return $this->render('AdminPanel/User/list_user.html.twig', array(
            'Users' => $User
        ));
    }

    /**
     * @Route("/admin_Cp/NewUser",name="NewUser")
     */
    public function NewUserAction(Request $request,FileUploader $fileUploader,UserPasswordEncoderInterface $passwordEncoder)
    {
        $User = new User();
        $form = $this->createForm(UserType::class,$User ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('NewUser'),
            [
                'name'     => null,
                'family'   => null,
                'email'    => null,
                'username' => null,
                'password' => null,
                'address'  => null,
                'telephon' => null,
                'mobile'   => null,
                'subject'  => null,
                'roles'    => null,
                'picUser'  => null]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

  
            $password = $passwordEncoder->encodePassword($User, $User->getPlainPassword());
            $User->setPassword($password);
            ////////////smallPic///////////
            $file = $User->getPicUser();
            $picUser = $fileUploader->uploadMainPics($file);
            $User->setPicUser($picUser);

            $data = $form->getData();
            var_dump($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash(
                'success',
                'کاربر جدید اضافه شد.'
            );

            return $this->redirect($request->getUri());

        }
        return $this->render('AdminPanel/User/new_user.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/EditUser/{id}" ,name="editUser")
     */
    public function EditUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo=$em->getRepository('App:User');
        $userData = $userRepo->find($id);


        $originPass = $userData->getPassword();
        $userData->setPassword("");
        // $satelliteImage=new satelliteImage;
        $user = new User();
        $form = $this->createForm(UserType::class,$user,array(
            'action' => $this->generateUrl('editUser',array('id' => $userData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'     => $userData->getName(),
                'family'   => $userData->getFamily(),
                'email'    => $userData->getEmail(),
                'username' => $userData->getUsername(),
                'password' => $userData->getPassword(),
                'address'  => $userData->getAddress(),
                'telephon' => $userData->getTelephon(),
                'mobile'   => $userData->getMobile(),
                'subject'  => $userData->getSubject(),
                'picUser'  => $userData->getPicUser()]
        ));


        return $this->render('AdminPanel/User/edit_user.html.twig', array(
            'form' => $form->createView(),
            'Users' => $userData
        ));
    }
    /**
     * @Route("/admin_Cp/User/deleteUserList/{id}",name="deleteUserList")
     *
     */
    public function deleteUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:User');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No User Found for id : ",$id);
        }$em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('ListUser');
    }
}
