<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;
use Sistema\AdminBundle\Entity\Repvolvo;
use Sistema\AdminBundle\Form\RepvolvoType;
use Sistema\AdminBundle\Form\RepvolvoFilterType;

//require_once("/home/fabian/sfprojects/vivalapizza/web/Classes/PHPExcel.php");
//        require_once("/home/fabian/sfprojects/vivalapizza/web/Classes/PHPExcel/Reader/Excel2007.php");
/**
 * Repvolvo controller.
 *
 * @Route("/repvolvo")
 */
class RepvolvoController extends Controller {

    /**
     * Lists all Repvolvo entities.
     *
     * @Route("/", name="repvolvo")
     * @Template()
     */
    public function indexAction() {
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
    protected function filter() {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new RepvolvoFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Repvolvo')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('RepvolvoControllerFilter');
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
                $session->set('RepvolvoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RepvolvoControllerFilter')) {
                $filterData = $session->get('RepvolvoControllerFilter');
                $filterForm = $this->createForm(new RepvolvoFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
     * Get results from paginator and get paginator view.
     *
     */
    protected function paginator($queryBuilder) {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me) {
                    return $me->generateUrl('repvolvo', array('page' => $page));
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
     * Finds and displays a Repvolvo entity.
     *
     * @Route("/{id}/show", name="repvolvo_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repvolvo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Repvolvo entity.
     *
     * @Route("/new", name="repvolvo_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Repvolvo();
        $form = $this->createForm(new RepvolvoType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Repvolvo entity.
     *
     * @Route("/create", name="repvolvo_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Repvolvo:new.html.twig")
     */
    public function createAction() {
        $entity = new Repvolvo();
        $request = $this->getRequest();
        $form = $this->createForm(new RepvolvoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('repvolvo_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.create.error');
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Repvolvo entity.
     *
     * @Route("/{id}/edit", name="repvolvo_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repvolvo entity.');
        }

        $editForm = $this->createForm(new RepvolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Repvolvo entity.
     *
     * @Route("/{id}/update", name="repvolvo_update")
     * @Method("post")
     * @Template("SistemaAdminBundle:Repvolvo:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repvolvo entity.');
        }

        $editForm = $this->createForm(new RepvolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('repvolvo_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Repvolvo entity.
     *
     * @Route("/{id}/delete", name="repvolvo_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Repvolvo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('repvolvo'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * @Route("/repuestos", name="repuestos")
     * @Template()
     */
    public function RepuestosAction() {
        return array();
    }

    /**
     * @Route("/subir", name="subir")
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
       $query="TRUNCATE repvolvo CASCADE";
       $result=pg_query($con, $query)or die('ERROR AL INSERTAR DATOS: ' . pg_last_error());
       for ($i = 1; $i <= $num; $i++) {
       $hola=$excel->getRowData($i);
       $query ="INSERT INTO repvolvo (id, codigo, descripcion, cd, precio, cantidad, tipo) VALUES ('$i', '$hola[0]', '$hola[1]','$hola[2]','$hola[3]','0', 'Volvo')"; 
       $result=pg_query($con, $query);
//       echo $hola[0].",".$hola[1].",".$hola[2].",".$hola[3];       
       }
       $pedidos="Carga Exitosa";
       //return array('entities' => $pedidos);
       return $this->redirect($this->generateUrl('repvolvo', array()));
    }
    
}
