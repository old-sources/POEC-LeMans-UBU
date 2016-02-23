<?php

namespace Jarry\UbuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Jarry\UbuBundle\Entity\Place;
use Jarry\UbuBundle\Form\PlaceType;

use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

/**
 * Place controller.
 *
 */
class PlaceController extends Controller {

    /**
     * Lists all Place entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();


        $thisUser = $this->getUser();
        $entities = $em->getRepository('JarryUbuBundle:Place')->findByOwner($thisUser);


        return $this->render('JarryUbuBundle:Place:index.html.twig', array(
                    'entities' => $entities,
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
        ));
    }

    /**
     * Creates a new Place entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Place();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $code = $this->uniqid_base36(true);
        $entity->setSecretCode($code);
        $entity->setOwner($this->container->get('security.context')->getToken()->getUser());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ubu_place_show', array('id' => $entity->getId())));
        }

        return $this->render('JarryUbuBundle:Place:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function uniqid_base36($more_entropy = false) {
        $s = uniqid('', $more_entropy);
        if (!$more_entropy):
            return base_convert($s, 16, 36);
        endif;
        $hex = substr($s, 0, 13);
        $dec = $s[13] . substr($s, 15); // skip the dot
        return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
    }

    /**
     * Creates a form to create a Place entity.
     *
     * @param Place $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Place $entity) {
        $form = $this->createForm(new PlaceType(), $entity, array(
            'action' => $this->generateUrl('ubu_place_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Place entity.
     *
     */
    public function newAction() {
        $entity = new Place();
        $form = $this->createCreateForm($entity);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Créer la place',
            'attr' => array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--indigo-100 mdl-color-text--purple-400 table_btn2')
        ));

        return $this->render('JarryUbuBundle:Place:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                    'carreTextCss' => $this->container->getParameter('carreTextCss'),
        ));
    }

    /**
     * Finds and displays a Place entity.
     *
     */
    public function showAction($id) {

        /* if(){
         * throw $this->createAccessDeniedException('You cannot edit this item.');
         * }
         */
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JarryUbuBundle:Place')->findOneById($id);
        
        $userPlaces = $this->getUser()->getPlacesUsers();
        dump($entity);
        foreach($userPlaces as $unePlace):
            dump($unePlace->getPlace()->getId());
        endforeach;
        
        if($userPlaces->contains($entity->getId())){
            dump($entity);
        }
        else{
            dump("raté");
        }
        

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->add('submit', SubmitType::class, array(
            'label' => 'Supprimer',
            'attr' => array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--indigo-100 mdl-color-text--purple-400 table_btn2')
        ));

        return $this->render('JarryUbuBundle:Place:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                    'carreTextCss' => $this->container->getParameter('carreTextCss'),
        ));
    }

    /**
     * Displays a form to edit an existing Place entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JarryUbuBundle:Place')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->add('submit', SubmitType::class, array(
            'label' => 'Sauvegarder',
            'attr' => array('class' => $this->container->getParameter('btn2Css'))
        ));
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->add('submit', SubmitType::class, array(
            'label' => 'Supprimer',
            'attr' => array('class' => $this->container->getParameter('btn2Css'))
        ));

        return $this->render('JarryUbuBundle:Place:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                    'carreTextCss' => $this->container->getParameter('carreTextCss'),
        ));
    }

    /**
     * Creates a form to edit a Place entity.
     *
     * @param Place $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Place $entity) {
        $form = $this->createForm(new PlaceType(), $entity, array(
            'action' => $this->generateUrl('ubu_place_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Place entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JarryUbuBundle:Place')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ubu_place_edit', array('id' => $id)));
        }

        return $this->render('JarryUbuBundle:Place:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Place entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JarryUbuBundle:Place')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Place entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ubu_place'));
    }

    /**
     * Creates a form to delete a Place entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('ubu_place_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }
    
    public function sharePlaceAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JarryUbuBundle:Place')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }
        
        return $this->render('JarryUbuBundle:Place:share.html.twig', array(
                    'entity' => $entity,
                    'message'=> 'Saisissez l\'email de la personne avec qui vous voulez partager la place, et un éventuel message' ,
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
        ));
    }
    
    public function sendPlaceAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JarryUbuBundle:Place')->find($id);
        
        if(!isset($_POST['mail'], $_POST['msg'])) {
            return $this->render('JarryUbuBundle:Place:share.html.twig', array(
                    'entity' => $entity,                    
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
            ));
        }
        else {
            $mailAdress = $_POST['mail'];
            $mailMsg = $_POST['msg'];
            $valide = false;
            
            $emailConstraint = new EmailConstraint();
            $emailConstraint->message = 'Vous n\'avez pas saisi un email valide';

            $errors = $this->get('validator')->validateValue(
                $mailAdress,
                $emailConstraint 
            );
            
            if ($errors == '' && $mailAdress != '') {
                $valide = true;
            }
            

            
            
            if ($valide) {
                
                $message = \Swift_Message::newInstance()
                    ->setSubject('Ubu Partage de monde')
                    ->setFrom('projet.informatique.ubu@gmail.com')
                    ->setTo($mailAdress)
                    ->setBody('Un utilisateur souhaite partager son monde sur UBU. Le code secret est '.$entity->getSecretCode())
                ;

                $this->get('mailer')->send($message);

               
                
                return $this->render('JarryUbuBundle:Place:sended.html.twig', array(
                    'entity' => $entity,
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                ));
            }
            else {
                return $this->render('JarryUbuBundle:Place:share.html.twig', array(
                    'entity' => $entity,
                    'message' => 'le mail saisi n\'est pas conforme',
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                ));
            }
        }
    }
    
    public function joinPlaceAction() {
        return $this->render('JarryUbuBundle:Place:join.html.twig', array(
                    
                    
                    'btnCss' => $this->container->getparameter('btnCss'),
                    'navCss' => $this->container->getparameter('navCss'),
                    'navDarkCss' => $this->container->getparameter('navDarkCss'),
                    'titreCss' => $this->container->getparameter('titreCss'),
                    'containerCss' => $this->container->getparameter('containerCss'),
                    'carreClicCss' => $this->container->getparameter('carreClicCss'),
                    'carreNewCss' => $this->container->getparameter('carreNewCss'),
                ));
    }

}
