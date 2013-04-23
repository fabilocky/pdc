<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Sistema\AdminBundle\Entity\Renaultrepuestos;
use Sistema\AdminBundle\Form\RenaultrepuestosType;
use Sistema\AdminBundle\Form\RenaultrepuestosFilterType;

/**
 * Renaultrepuestos controller.
 *
 * @Route("/renaultrepuestos")
 */
class RenaultrepuestosController extends Controller
{
    /**
     * Lists all Renaultrepuestos entities.
     *
     * @Route("/", name="renaultrepuestos")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

    
        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new RenaultrepuestosFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->createQueryBuilder('e');
    
        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('RenaultrepuestosControllerFilter');
        }
    
        // Filter action
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('RenaultrepuestosControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RenaultrepuestosControllerFilter')) {
                $filterData = $session->get('RenaultrepuestosControllerFilter');
                $filterForm = $this->createForm(new RenaultrepuestosFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }
    
        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();
    
        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('renaultrepuestos', array('page' => $page));
        };
    
        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));
    
        return array($entities, $pagerHtml);
    }
    
    /**
     * Finds and displays a Renaultrepuestos entity.
     *
     * @Route("/{id}/show", name="renaultrepuestos_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultrepuestos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Renaultrepuestos entity.
     *
     * @Route("/new", name="renaultrepuestos_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Renaultrepuestos();
        $form   = $this->createForm(new RenaultrepuestosType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Renaultrepuestos entity.
     *
     * @Route("/create", name="renaultrepuestos_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultrepuestos:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Renaultrepuestos();
        $request = $this->getRequest();
        $form    = $this->createForm(new RenaultrepuestosType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('renaultrepuestos_show', array('id' => $entity->getId())));        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.create.error');
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Renaultrepuestos entity.
     *
     * @Route("/{id}/edit", name="renaultrepuestos_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultrepuestos entity.');
        }

        $editForm = $this->createForm(new RenaultrepuestosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Renaultrepuestos entity.
     *
     * @Route("/{id}/update", name="renaultrepuestos_update")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultrepuestos:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultrepuestos entity.');
        }

        $editForm   = $this->createForm(new RenaultrepuestosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('renaultrepuestos_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Renaultrepuestos entity.
     *
     * @Route("/{id}/delete", name="renaultrepuestos_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Renaultrepuestos entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('renaultrepuestos'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
     /**
     * @Route("/repuestos", name="repuestos_ren")
     * @Template()
     */
    public function RepuestosAction() {
        return array();
    }

    /**
     * @Route("/subir", name="subir_ren")
     * @Template()
     */
    public function subirAction() {
        $nombre_archivo = $_FILES['userfile']['name'];
        $tipo_archivo = $_FILES['userfile']['type'];
        $tamano_archivo = $_FILES['userfile']['size'];

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], "excel.xlsx")) {
            echo "El archivo ha sido cargado correctamente.";
        } else {
            echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
        }
        
       $excel = $this->get('os.excel');
       $excel->loadFile("excel.xlsx");
       $num=$excel->getRowCount();
       $con = pg_connect("host=localhost port=5432 dbname=pdc user=postgres password=postgres");
       $query="TRUNCATE renaultrepuestos CASCADE";
       $result=pg_query($con, $query)or die('ERROR AL INSERTAR DATOS: ' . pg_last_error());
       for ($i = 1; $i <= $num; $i++) {
       $hola=$excel->getRowData($i);
       $query ="INSERT INTO renaultrepuestos (id, codigo, descripcion, cd, precio, cantidad) VALUES ('$i', '$hola[0]', '$hola[1]','$hola[2]','$hola[2]','0')"; 
       $result=pg_query($con, $query);
//       echo $hola[0].",".$hola[1].",".$hola[2].",".$hola[3];       
       }
       $pedidos="Carga Exitosa";
       return array('entities' => $pedidos);
    }
}
