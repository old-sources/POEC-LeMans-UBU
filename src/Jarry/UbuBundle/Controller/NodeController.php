<?php

namespace Jarry\UbuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Jarry\UbuBundle\Entity\Node;
use Jarry\UbuBundle\Form\NodeType;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Jarry\UbuBundle\Entity\Log\HeatingLog;

/**
 * Node controller.
 *
 */
class NodeController extends Controller
{

    /**
     * Lists all Node entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JarryUbuBundle:Node')->findAll();

        return $this->render('JarryUbuBundle:Node:index.html.twig', array(
            'entities' => $entities,
            'navCss' => $this->container->getparameter('navCss'),
            'navDarkCss' => $this->container->getparameter('navDarkCss'),
            'titreCss' => $this->container->getparameter('titreCss'),
            'containerCss' => $this->container->getparameter('containerCss'),
            'carreClicCss' => $this->container->getparameter('carreClicCss'),
            'carreNewCss' => $this->container->getparameter('carreNewCss'),
        ));
    }
    /**
     * Creates a new Node entity.
     *
     */
    public function createAction(Request $request, $idPlace, $idZone)
    {
        $em = $this->getDoctrine()->getManager();
        
        $zone = ($em->getRepository('JarryUbuBundle:Zone')->findOneById($idZone));
        $entity = new Node();
        $entity->setZone($zone);
        $form = $this->createCreateForm($entity, $idPlace, $idZone);
        $form->handleRequest($request);

        if ($form->isValid()) {
           
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('node_show', array('id' => $entity->getId(), 'idPlace' => $idPlace, 'idZone' => $idZone)));
        }

        return $this->render('JarryUbuBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'idPlace' => $idPlace,
            'idZone' => $idZone,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Node $entity, $idPlace, $idZone)
    {
        $form = $this->createForm(new NodeType(), $entity, array(
            'action' => $this->generateUrl('node_create', array('idPlace' => $idPlace, 'idZone' => $idZone)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Node entity.
     *
     */
    public function newAction($idPlace, $idZone)
    {
        
       
        $entity = new Node();
        
        $form   = $this->createCreateForm($entity, $idPlace, $idZone);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Ajouter',
            'attr'  => array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--indigo-100 mdl-color-text--purple-400 table_btn2')
        ));

        return $this->render('JarryUbuBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'idZone' => $idZone,
            'idPlace' => $idPlace,
            'form'   => $form->createView(),
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
     * Finds and displays a Node entity.
     *
     */
    public function showAction($id, $idPlace, $idZone)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JarryUbuBundle:Node')->findOneById($id);
        $entity->capaConstruct();
        
        // creation des données
        $construitDonnees = array();
        $construitTime = array();
        
        $titre = 'statistiques';
        switch ($entity->getNodeType()) {
            case 'rad':
                $repository =  $em->getRepository('JarryUbuBundle:Log\HeatingLog');
                $query = $em->createQuery(
                    "SELECT h
                    FROM JarryUbuBundle:Log\HeatingLog h
                    WHERE h.nodeId = :node
                    ORDER BY h.dateOfLog ASC"
                )->setParameter('node', $id);
                /*$heatingLogs = $repository->findBy(
                        array('nodeId' => $id)
                    );*/
                $heatingLogs = $query->getResult();
                $ttSensorArray = array();
                $teSensorArray = array();
                $tActorArray = array();
                $time = 1;
                foreach ($heatingLogs as $heatingLog) {
                    $ttSensorArray[] = $heatingLog->getTempTargetSensor();
                    $teSensorArray[] = $heatingLog->getTempEnvSensor();
                    $tActorArray[] = $heatingLog->getTempActor();
                    $construitTime[] = $heatingLog->getDateOfLog()->format(/*'Y-m-d */'H:i:s');
                    $time++;
                }
                
                $construitDonnees1 = array(
                    'name' => 'Temp pièce',
                    'data' => $teSensorArray
                    );
                $construitDonnees2 = array(
                    'name' => 'Temp radiateur',
                    'data' => $ttSensorArray
                    );
                $construitDonnees3 = array(
                    'name' => 'Temp programmée',
                    'data' => $tActorArray
                    );
                break;
            default :
        }
        $donnees = array(
            $construitDonnees1,
            $construitDonnees2,
            $construitDonnees3

        );
        $donneesTemps = $construitTime;
        // utilisation de Ob
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text($titre);

        $ob->yAxis->title(array('text' => "Températures"));

        $ob->xAxis->title(array('text'  => "Heure"));
        $ob->xAxis->categories($donneesTemps);

        $ob->series($donnees);
        
        var_dump($heatingLogs);
        // fin des ob
        

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $idPlace, $idZone);
        $deleteForm->add('submit', SubmitType::class, array(
            'label' => 'Supprimer',
            'attr'  => array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--indigo-100 mdl-color-text--purple-400 table_btn2')
        ));

        return $this->render('JarryUbuBundle:Node:show.html.twig', array(
            'entity'      => $entity,
            'linechart' => $ob,
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
     * Displays a form to edit an existing Node entity.
     *
     */
    public function editAction($id, $idPlace, $idZone)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JarryUbuBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $editForm = $this->createEditForm($entity, $idPlace, $idZone);
        $editForm->add('submit', SubmitType::class, array(
            'label' => 'Sauvegarder',
            'attr'  => array('class' => $this->container->getParameter('btn2Css'))
        ));
        $deleteForm = $this->createDeleteForm($id, $idPlace, $idZone);
        $deleteForm->add('submit', SubmitType::class, array(
            'label' => 'Supprimer',
            'attr'  => array('class' => $this->container->getParameter('btn2Css'))
        ));

        return $this->render('JarryUbuBundle:Node:edit.html.twig', array(
            'entity'      => $entity,
            'idPlace' => $idPlace,
            'idZone' => $idZone,
            'edit_form'   => $editForm->createView(),
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
    * Creates a form to edit a Node entity.
    *
    * @param Node $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Node $entity, $idPlace, $idZone)
    {
        $form = $this->createForm(new NodeType(), $entity, array(
            'action' => $this->generateUrl('node_update', array('id' => $entity->getId(), 'idPlace' => $idPlace, 'idZone' => $idZone)),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Node entity.
     *
     */
    public function updateAction(Request $request, $id, $idPlace, $idZone)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JarryUbuBundle:Node')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $idPlace, $idZone);
        $editForm = $this->createEditForm($entity, $idPlace, $idZone);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('node_edit', array('id' => $id, 'idPlace' => $idPlace, 'idZone' => $idZone)));
        }

        return $this->render('JarryUbuBundle:Node:edit.html.twig', array(
            'entity'      => $entity,
            'idPlace' => $idPlace,
            'idZone' => $idZone,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Node entity.
     *
     */
    public function deleteAction(Request $request, $id, $idPlace, $idZone)
    {
        $form = $this->createDeleteForm($id, $idPlace, $idZone);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JarryUbuBundle:Node')->find($id);
            $zone = $entity->getZone()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Node entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('zone_show', array('id' => $zone, 'idPlace' => $idPlace)));
    }

    /**
     * Creates a form to delete a Node entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id, $idPlace, $idZone)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('node_delete', array('id' => $id, 'idPlace' => $idPlace, 'idZone' => $idZone)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
