<?php
namespace CGI\GedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }
        return $this->render('CGIGedBundle:security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * @Route("/redirectUser", name="redirect_user")
     */
    public function redirectUserAction()
    {

        if($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))
        {
            //return $this->render(':Default:index.html.twig');
            //return $this->render('CGICommentBundle:Default:index.html.twig');
            return $this->redirectToRoute('my_comments');

        }
        else
        {
           return $this->redirectToRoute('login');
            //return $this->render(':Default:index.html.twig');
        }
    }
    
}