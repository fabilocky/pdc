<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Sistema\AdminBundle\Entity\Remitovolvo;
use Sistema\AdminBundle\Form\RemitovolvoType;
use Sistema\AdminBundle\Form\RemitovolvoFilterType;

use Sistema\AdminBundle\Entity\Consumo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Remitovolvo controller.
 *
 * @Route("/remitovolvo")
 */
class RemitovolvoController extends Controller
{
    /**
     * Lists all Remitovolvo entities.
     *
     * @Route("/", name="remitovolvo")
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
        $filterForm = $this->createForm(new RemitovolvoFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Remitovolvo')->createQueryBuilder('e');
    
        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('RemitovolvoControllerFilter');
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
                $session->set('RemitovolvoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RemitovolvoControllerFilter')) {
                $filterData = $session->get('RemitovolvoControllerFilter');
                $filterForm = $this->createForm(new RemitovolvoFilterType(), $filterData);
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
            return $me->generateUrl('remitovolvo', array('page' => $page));
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
     * Finds and displays a Remitovolvo entity.
     *
     * @Route("/{id}/show", name="remitovolvo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Remitovolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Remitovolvo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Remitovolvo entity.
     *
     * @Route("/new", name="remitovolvo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Remitovolvo();
        $form   = $this->createForm(new RemitovolvoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Remitovolvo entity.
     *
     * @Route("/create", name="remitovolvo_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Remitovolvo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $ord = new Remitovolvo();       
        $ords = $request->request->get('remitovolvo', array());            
        
        $cont=0;
        if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];
            foreach($consumos as $consumo) {               
                $str = $consumo['subtotal'];
                $fa=str_replace(".", ",",$str);
                $consumo['subtotal']=$fa;                
                $cont=$cont+1;
            }
            for ($i = 0; $i <= $cont; $i++) {
                $consumos[$i] = new \Sistema\AdminBundle\Entity\Consumoremito();
                $ord->addConsumos($consumos[$i]);                
            }
        }
 
        $form = $this->createForm(new RemitovolvoType(), $ord);        
        $form->bindRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ord);
            $em->flush();
 
            return $this->redirect($this->generateUrl('remitovolvo_show', array('id' => $ord->getId())));   
        }
 
        return array(
            'form' => $form->createView()
        );
    }
    /**
     * Displays a form to edit an existing Remitovolvo entity.
     *
     * @Route("/{id}/edit", name="remitovolvo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Remitovolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Remitovolvo entity.');
        }

        $editForm = $this->createForm(new RemitovolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Remitovolvo entity.
     *
     * @Route("/{id}/update", name="remitovolvo_update")
     * @Method("post")
     * @Template("SistemaAdminBundle:Remitovolvo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Remitovolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Remitovolvo entity.');
        }

        $editForm   = $this->createForm(new RemitovolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('remitovolvo_edit', array('id' => $id)));
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
     * Deletes a Remitovolvo entity.
     *
     * @Route("/{id}/delete", name="remitovolvo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Remitovolvo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Remitovolvo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('remitovolvo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
     /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/repvolvo/preciorem", name="remitovolvo_repvolvo_preciorem")
     */
    public function retornaPrecioRepvolvo() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->findOneByCodigo($id);
            return new Response($entity->getPrecio());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
     /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/repvolvo/nombrerem", name="remitovolvo_repvolvo_nombrerem")
     */
    public function retornaNombreRepvolvo() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->findOneByCodigo($id);
            return new Response($entity->getId());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
    /**
     * Displays a form to edit an existing Remitovolvo entity.
     *
     * @Route("/{id}/generar", name="remitovolvo_generar")
     * @Template()
     */
    public function generarAction($id)
    {
        $rem = new Remitovolvo();                    
        $em = $this->getDoctrine()->getManager();
        $ord = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
        
        $originalCons= array();    
        foreach ($ord->getConsumos() as $consumo) {
        $originalCons[] = $consumo;       
        }
        $cont=0;
        
        if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];
            foreach($consumos as $consumo) {               
                $str = $consumo['subtotal'];
                $fa=str_replace(".", ",",$str);
                $consumo['subtotal']=$fa;                
                $cont=$cont+1;
            }
            for ($i = 0; $i <= $cont; $i++) {
                $consumos[$i] = new \Sistema\AdminBundle\Entity\Consumoremito();
                $ord->addConsumos($consumos[$i]);                
            }
        }
 
        $form = $this->createForm(new RemitovolvoType(), $ord);        
        $form->bindRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ord);
            $em->flush();
 
            return $this->redirect($this->generateUrl('remitovolvo_show', array('id' => $ord->getId())));   
        }
 
        return array(
            'form' => $form->createView()
        );
    }
    
            /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/reporte", name="remito_imprimir")
     * @Template()
     */
    public function imprimirRemitoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Remitovolvo')->find($id);        
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }
        
        $contenido = $this->renderView('SistemaAdminBundle:Remitovolvo:imprimirRemito.pdf.twig', array(
            'entity'    => $entity,            
        ));

        $pdf = <<<EOD
<style>
table {
    table-layout: fixed;
    width: 100%;
    font-size: 10pt;
}
.table-bordered {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: separate;
    border-color: #DDDDDD;
    border-image: none;
    border-radius: 4px;
    border-style: solid;
    border-width: 1px;
}
.table-bordered td {
    border: solid thin #DDDDDD;
}
.table-bordered td.th {
    font-weight: bold;
}
</style>
$contenido
EOD;

        return $this->get('sistema_tcpdf')->quick_pdf($pdf);
    }
}
