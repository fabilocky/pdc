<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;
use Liuggio\ExcelBundle\LiuggioExcelBundle;

use Sistema\AdminBundle\Entity\Ordvolvo;
use Sistema\AdminBundle\Form\OrdvolvoType;
use Sistema\AdminBundle\Form\OrdvolvoFilterType;
use Sistema\AdminBundle\Entity\Solicrep;
use Sistema\AdminBundle\Entity\Consumo;
use Sistema\AdminBundle\Entity\Operaciones;
use Sistema\AdminBundle\Entity\Terceros;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Style_Color;
use \PHPExcel_Style_Alignment;
use \PHPExcel_Style_Border;
/**
 * Ordvolvo controller.
 *
 * @Route("/ordvolvo")
 */
class OrdvolvoController extends Controller
{
    /**
     * Lists all Ordvolvo entities.
     *
     * @Route("/", name="ordvolvo")
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
        $filterForm = $this->createForm(new OrdvolvoFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Ordvolvo')->createQueryBuilder('e');
    
        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('OrdvolvoControllerFilter');
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
                $session->set('OrdvolvoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('OrdvolvoControllerFilter')) {
                $filterData = $session->get('OrdvolvoControllerFilter');
                $filterForm = $this->createForm(new OrdvolvoFilterType(), $filterData);
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
            return $me->generateUrl('ordvolvo', array('page' => $page));
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
     * Finds and displays a Ordvolvo entity.
     *
     * @Route("/{id}/show", name="ordvolvo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
        
        $consumos=$entity->getConsumos();
        foreach($consumos as $consumo) {               
                $hola=$consumo->getRemitovolvo();
                //var_dump($hola);die();
                //$num=$hola->getId();
                //var_dump($num);die();
            }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }
        
        if ($num = NULL){
            $num=0;
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'num'         => $num,
        );
    }

     /**
     * Displays a form to create a new OrdVolvo entity.
     *
     * @Route("/new", name="new_ordvolvo")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $ord = new Ordvolvo();
//        $fec= date("d-m-Y");
//        $ord->setFecha(date("d-m-Y"));
//        $solicitud1 = new Solicrep();
//        $ord->addSolicitudes($solicitud1);
//        $consumo1 = new Consumo();
//        $ord->addConsumos($consumo1);
        
        $data = file_get_contents("https://hb.bbv.com.ar/fnet/mod/inversiones/NL-dolareuro.jsp");
 
//        if ( preg_match('|<td align="right" class="texto2">UF : </td>\s+<td class="texto2"><b>(.*?)</b></td>|is' , $data , $cap ) )
//        {
//        echo "UF ".$cap[1];
//        }
        if ( preg_match('|<td style="text-align: left;">Dolar</td>
<td style="text-align: center;">(.*?)</td>
<td style="text-align: center;">(.*?)</td></tr>|is' , $data , $cap ) )
        {
        $str = $cap[2];
        $fa=str_replace(",", ".",$str);
        }else{
            $fa=0;
        }
        
        $form = $this->createForm(new OrdvolvoType(), $ord);
 
        return $this->render('SistemaAdminBundle:Ordvolvo:new.html.twig', array(
            'form' => $form->createView(),
            'dolar'=> $fa,
        ));
    }

    /**
     * Creates a new Task entity.
     *
     * @Route("/create", name="ordvolvo_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Ordvolvo:new.html.twig")
     */
     public function createAction(Request $request)
    { 
        $ord = new Ordvolvo();     
        //$rem = new \Sistema\AdminBundle\Entity\Remitovolvo();
        $ords = $request->request->get('ordvolvo', array());        
        $cliente=$ords['client'];        
        if (isset($ords['solicitudes'])) {
            $solicitudes = $ords['solicitudes'];
            foreach($solicitudes as $solicitud) {                
                $solicitud = new Solicrep();
                $ord->addSolicitudes($solicitud);
            }
        }       
        $sumaNeto=0;
        $cont=0;
        if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];
            $consumoremito = $ords['consumos'];
            foreach($consumos as $consumo) {               
                $id1=$consumo["idRepvolvo"];
                $em1 = $this->getDoctrine()->getManager();
                $rep = $em1->getRepository('SistemaAdminBundle:Repvolvo')->find($id1);
                $rep->setCantidad($rep->getCantidad()-1);
                $em1->persist($rep);
                $sumaNeto= $sumaNeto + $consumo['subtotal'];
                $str = $consumo['subtotal'];
                $fa=str_replace(".", ",",$str);
                $consumo['subtotal']=$fa;                
                $cont=$cont+1;
                
            }
            for ($i = 0; $i <= $cont; $i++) {               
                $consumos[$i] = new Consumo();            
                $ord->addConsumos($consumos[$i]);
                
            }
        }       
        
        $cont1=0;
        if (isset($ords['operaciones'])) {
            $operaciones = $ords['operaciones'];
//            var_dump($operaciones);die();
            foreach($operaciones as $operacion) {
                $str1 = $operacion['hs'];
                $fa1=str_replace(".", ",",$str1);
                $operacion['hs']=$fa1;   
                $str2 = $operacion['subtotal'];
                $fa2=str_replace(".", ",",$str2);
                $operacion['subtotal']=$fa2;
                $cont1=$cont1+1;
            }
            for ($i = 0; $i <= $cont1; $i++) {
                $operaciones[$i] = new Operaciones();
                $ord->addOperaciones($operaciones[$i]);                
            }
        }
        
        $cont2=0;
        if (isset($ords['terceros'])) {
            $terceros = $ords['terceros'];
            foreach($terceros as $tercero) {
                $str3 = $tercero['unitario'];
                $fa3=str_replace(".", ",",$str3);
                $tercero['unitario']=$fa3;   
                $str4 = $tercero['subtotal'];
                $fa4=str_replace(".", ",",$str4);
                $tercero['subtotal']=$fa4;
                $cont2=$cont2+1;
            }
            for ($i = 0; $i <= $cont2; $i++) {
                $terceros[$i] = new Terceros();
                $ord->addTerceros($terceros[$i]);                
            }
        }     
        
 
        $form = $this->createForm(new OrdvolvoType(), $ord);        
        $form->bindRequest($request);
        
        if ($form->isValid()) {
//            var_dump($ord);die();
        $em2 = $this->getDoctrine()->getManager();
        $cli = $em2->getRepository('SistemaAdminBundle:Cliente')->findOneByNombre($cliente);
        $ord->setCliente($cli);        
        //$rem->setCliente($ord->getCliente());
        //$rem->setChasis($ord->getChasis());
        //$rem->setCotizacion($ord->getCotizacion());
        //$rem->setDominio($ord->getDominio());
        //$rem->setFecha($ord->getFecha());
        //$rem->setModelo($ord->getModelo());
        //$rem->setNeto($sumaNeto);
        //$rem->setEnvia('María Antonella Pescarolo');
        //$rem->setConsumos($ord->getConsumos());
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ord);
            //$em->persist($rem);
            $em->flush();
 
            return $this->redirect($this->generateUrl('ordvolvo_show', array('id' => $ord->getId())));   
        }
 
        return array(
            'form' => $form->createView()
        );
    }
    /**
     * Displays a form to edit an existing Ordvolvo entity.
     *
     * @Route("/{id}/edit", name="ordvolvo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        $editForm = $this->createForm(new OrdvolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing Ordvolvo entity.
     *
     * @Route("/{id}/update", name="ordvolvo_editar")
     * @Method("post")
     * @Template("SistemaAdminBundle:Ordvolvo:edit.html.twig")
     */
    public function editarAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $ord = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
    $deleteForm = $this->createDeleteForm($id);
    
    if (!$ord) {
        throw $this->createNotFoundException('No ord found for is '.$id);
    }
    $originalSolic= array();    
    foreach ($ord->getSolicitudes() as $solicitud) {
        $originalSolic[] = $solicitud;       
    }
    $originalCons= array();    
    foreach ($ord->getConsumos() as $consumo) {
        $originalCons[] = $consumo;       
    }
    $originalOper= array();    
    foreach ($ord->getOperaciones() as $operacion) {
        $originalOper[] = $operacion;       
    }
    $originalTerc= array();    
    foreach ($ord->getTerceros() as $tercero) {
        $originalTerc[] = $tercero;       
    }
    
    $editForm = $this->createForm(new OrdvolvoType(), $ord);
            
            $ords = $request->request->get('ordvolvo', array());
            if (isset($ords['solicitudes'])) {
            $solicitudes = $ords['solicitudes'];            
            $i=0;
            foreach( $originalSolic as $solicitud ) {
                $solicitud->setDescripcion($solicitudes[$i]['descripcion']);               
                $em->persist($solicitud);
                $i++;
            }
            }
            if (isset($ords['operaciones'])) {
            $operaciones = $ords['operaciones'];            
            $i=0;
            foreach( $originalOper as $operacion ) {
                $operacion->setDenominacion($operaciones[$i]['denominacion']);
                $operacion->setHs($operaciones[$i]['hs']);
                $operacion->setSubtotal($operaciones[$i]['subtotal']);
                $em->persist($operacion);
                $i++;
            }
            }
            if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];            
            $i=0;
            foreach( $originalCons as $consumo ) {
//                $consumo=new Consumo();
                $id1=$consumos[$i]['idRepvolvo'];
                $em1 = $this->getDoctrine()->getManager();
                $rep = $em1->getRepository('SistemaAdminBundle:Repvolvo')->find($id1);
//                var_dump($rep); die;
                $consumo->setOrdvolvo($ord);
                $consumo->setCantidad($consumos[$i]['cantidad']);
                $consumo->setSubtotal($consumos[$i]['subtotal']);
                $consumo->setIdRepvolvo($rep);
                $em->persist($consumo);
                $i++;
            }
            }
            $em->persist($ord);
            $em->flush();
                   

            
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('ordvolvo_edit', array('id' => $id)));
        
    
    return array(
            'entity'      => $ord,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        }

    
    /**
     * Deletes a Ordvolvo entity.
     *
     * @Route("/{id}/delete", name="ordvolvo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('ordvolvo'));
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
     * @Route("/repvolvo/stock", name="orden_repvolvo_precio")
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
     * @Route("/repvolvo/precio", name="orden_repvolvo_stock")
     */
    public function retornaStockRepvolvo() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Repvolvo')->findOneByCodigo($id);            
            return new Response($entity->getCantidad());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
     /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/repvolvo/nombre", name="orden_repvolvo_nombre")
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
     * @Route("/ajax_member", name="ajax_member")
     */
    public function ajaxMemberAction(Request $request)
    {
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $members = $em->getRepository('SistemaAdminBundle:Repvolvo')->findAjaxValue($value);

        $json = array();
        foreach ($members as $member) {
            $json[] = array(
                'label' => $member->getName(),
                'value' => $member->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
    
    /**
     * @Route("/ajax", name="ajax")
     */
    public function ajaxAction(Request $request)
    {
        $value = $request->get('term');

        // .... (Search values)
        $search = array(
            array('value' => 'foo', 'label' => 'Foo'),
            array('value' => 'bar', 'label' => 'Bar')
        );

        $response = new Response();
        $response->setContent(json_encode($search));

        return $response;
    }
    
    /**
* @Route("/ajax_agente", name="ajax_agente")
*/
public function ajaxAgenteAction() {
        $request = $this->getRequest();
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $members = $em->getRepository('SistemaAdminBundle:Cliente')->findAjaxCliente($value);

        $json = array();
        foreach ($members as $member) {
            $json[] = array(
                'label' => $member->getNombre(),
                'value' => $member->getNombre()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
    
     /**
     * @Route("/ejemploless", name="ejemplo_less")
     * @Template()
     */
    public function ejemplolessAction()
    {
        return array();
    }
    
        /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/reporte", name="orden_imprimir")
     * @Template()
     */
    public function imprimirOrdenAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);        
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }
        
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirOrden.pdf.twig', array(
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
    
        /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/remito", name="remito_imprimir")
     * @Template()
     */
    public function imprimirRemitoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);        
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }
        
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirRemito.pdf.twig', array(
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
    
        /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/ordenexcel", name="orden_imprimir_excel")
     * @Template()
     */
    public function imprimirOrdenExcelAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        // Creamos un objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Leemos un archivo Excel 2007
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('archivo.xlsx');
        
        $fecha = $entity->getFecha()->format('d-m-Y');
        // Indicamos que se pare en la hoja uno del libro
        $objPHPExcel->setActiveSheetIndex(0);        
        //Escribimos en la hoja en la celda B1
        $objPHPExcel->getActiveSheet()->SetCellValue('J6', $entity->getCotizacion());
        $objPHPExcel->getActiveSheet()->SetCellValue('K4', $fecha);
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', $entity->getId());
        $objPHPExcel->getActiveSheet()->SetCellValue('C7', $entity->getCliente()->getNombre());
        $objPHPExcel->getActiveSheet()->SetCellValue('H7', $entity->getCliente()->getCuit());
        $objPHPExcel->getActiveSheet()->SetCellValue('C8', $entity->getChofer());
        $objPHPExcel->getActiveSheet()->SetCellValue('K8', $entity->getCliente()->getTelefono());
        $objPHPExcel->getActiveSheet()->SetCellValue('D9', $entity->getChasis());
        $objPHPExcel->getActiveSheet()->SetCellValue('H9', $entity->getModelo());
        $objPHPExcel->getActiveSheet()->SetCellValue('H10', $entity->getColor());
        $objPHPExcel->getActiveSheet()->SetCellValue('C10', $entity->getDominio());
        $objPHPExcel->getActiveSheet()->SetCellValue('F10', $entity->getKm());
        $objPHPExcel->getActiveSheet()->SetCellValue('J10', 'HS:');
        $objPHPExcel->getActiveSheet()->SetCellValue('K10', $entity->getHs());
        
        $a=14;
        foreach ($entity->getSolicitudes() as $solicitud) {
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $solicitud->getDescripcion());
        $a++;
        }
        
        $b=22;
        foreach ($entity->getConsumos() as $consumo) {
        $precio=$consumo->getSubtotal()/$consumo->getCantidad();
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$b, $consumo->getCantidad());
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$b, $consumo->getIdRepvolvo()->getCodigo());
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$b, $consumo->getIdRepvolvo()->getDescripcion());
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$b, $precio);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$b, $consumo->getSubtotal());
        $b++;
        }
        
        $c=34;
        foreach ($entity->getOperaciones() as $operacion) {
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$c, $operacion->getDenominacion());
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$c, $operacion->getHs());
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$c, $operacion->getSubtotal());       
        $c++;
        }
        
        $d=43;
        foreach ($entity->getTerceros() as $tercero) {
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$d, $tercero->getCantidad());
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$d, $tercero->getCantidad());
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$d, $tercero->getDenominacion());
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$d, $tercero->getUnitario());
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$d, $tercero->getSubtotal());
        $d++;
        }
        
        
//        // Color rojo al texto
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
//        // Texto alineado a la derecha
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        // Damos un borde a la celda
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        //Guardamos el archivo en formato Excel 2007
        //Si queremos trabajar con Excel 2003, basta cambiar el ‘Excel2007′ por ‘Excel5′ y el nombre del archivo de salida cambiar su formato por ‘.xls’
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("Orden_volvo".$id.".xlsx");
        return $this->redirect($this->generateUrl('ordvolvo_show', array('id' => $id)));
    }
    
     /**
     * @Route("/excel", name="excel")
     * @Template()
     */
    public function excelAction($name="hola")
    {       

        // ask the service for a Excel5
        $excelService = $this->get('xls.service_xls5');
        // or $this->get('xls.service_pdf');
        // or create your own is easy just modify services.yml
       
        // create the object see http://phpexcel.codeplex.com documentation
        $excelService->excelObj->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("Office 2005 XLSX Test Document")
                            ->setSubject("Office 2005 XLSX Test Document")
                            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                            ->setKeywords("office 2005 openxml php")
                            ->setCategory("Test result file");
        $excelService->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!');                    
        $excelService->excelObj->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelService->excelObj->setActiveSheetIndex(0);

        //create the response
        $response = $excelService->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;        
    }
    
    /**
     * @Route("/verarticulos", name="ver_articulos")
     * @Template()
     */
    public function verArticulosAction()
{
        return $this->render('SistemaAdminBundle:Cliente:new.html.twig', array());
}

     /**
     * Edits an existing Ordvolvo entity.
     *
     * @Route("/{id}/generaremito", name="ordvolvo_remito")     
     * @Template()
     */
    public function GenerarRemitoAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $ord = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
    //$deleteForm = $this->createDeleteForm($id);
    $rem = new \Sistema\AdminBundle\Entity\Remitovolvo();
    
    if (!$ord) {
        throw $this->createNotFoundException('No ord found for is '.$id);
    }
    $originalSolic= array();    
    foreach ($ord->getSolicitudes() as $solicitud) {
        $originalSolic[] = $solicitud;       
    }
    $originalCons= array();    
    foreach ($ord->getConsumos() as $consumo) {
        $originalCons[] = $consumo;
        $consremito= new Consumo();
        $consremito->setCantidad($consumo->getCantidad());
        $consremito->setGarantia($consumo->getGarantia());
        $consremito->setIdRepvolvo($consumo->getIdRepvolvo());
        $consremito->setRemitovolvo($rem);
        $consremito->setSubtotal($consumo->getSubtotal());
        $rem->addConsumos($consremito);
    }
    $originalOper= array();    
    foreach ($ord->getOperaciones() as $operacion) {
        $originalOper[] = $operacion;       
    }
    $originalTerc= array();    
    foreach ($ord->getTerceros() as $tercero) {
        $originalTerc[] = $tercero;       
    }
    //var_dump($originalCons[0]);die();
    
    
//    $editForm = $this->createForm(new RemitovolvoType(), $ord);
            
           
        $rem->setCliente($ord->getCliente());
        $rem->setChasis($ord->getChasis());
        $rem->setCotizacion($ord->getCotizacion());
        $rem->setDominio($ord->getDominio());
        $rem->setFecha($ord->getFecha());
        $rem->setModelo($ord->getModelo());
        $rem->setNeto($ord->getNeto());
        $rem->setEnvia('María Antonella Pescarolo');
        //$rem->setConsumos($originalCons);
            $em->persist($rem);
            $em->flush();
                   

            
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('remitovolvo_show', array('id' => $rem->getId())));
        
    
//    return array(
//            'entity'      => $ord,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
        }


 
}
