<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Sistema\AdminBundle\Entity\Renaultorden;
use Sistema\AdminBundle\Form\RenaultordenType;
use Sistema\AdminBundle\Form\RenaultordenFilterType;
use Sistema\AdminBundle\Entity\Renaultconsumo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Style_Color;
use \PHPExcel_Style_Alignment;
use \PHPExcel_Style_Border;
/**
 * Renaultorden controller.
 *
 * @Route("/renaultorden")
 */
class RenaultordenController extends Controller
{
    /**
     * Lists all Renaultorden entities.
     *
     * @Route("/", name="renaultorden")
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
        $filterForm = $this->createForm(new RenaultordenFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Renaultorden')->createQueryBuilder('e');
    
        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('RenaultordenControllerFilter');
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
                $session->set('RenaultordenControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RenaultordenControllerFilter')) {
                $filterData = $session->get('RenaultordenControllerFilter');
                $filterForm = $this->createForm(new RenaultordenFilterType(), $filterData);
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
            return $me->generateUrl('renaultorden', array('page' => $page));
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
     * Finds and displays a Renaultorden entity.
     *
     * @Route("/{id}/show", name="renaultorden_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultorden entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Renaultorden entity.
     *
     * @Route("/new", name="renaultorden_new")
     * @Template()
     */
    public function newAction()
    {
        $ord = new Renaultorden();
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
        
        $form = $this->createForm(new RenaultordenType(), $ord);
 
        return $this->render('SistemaAdminBundle:Renaultorden:new.html.twig', array(
            'form' => $form->createView(),
            'dolar'=> $fa,
        ));
    }

    /**
     * Creates a new Renaultorden entity.
     *
     * @Route("/create", name="renaultorden_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultorden:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $ord = new Renaultorden();     
        //$rem = new \Sistema\AdminBundle\Entity\Remitovolvo();
        $ords = $request->request->get('renaultorden', array());        
        $cliente=$ords['client'];        
        if (isset($ords['solicitudes'])) {
            $solicitudes = $ords['solicitudes'];
            foreach($solicitudes as $solicitud) {                
                $solicitud = new \Sistema\AdminBundle\Entity\Renaultsolicrep();
                $ord->addSolicitudes($solicitud);
            }
        }       
        $sumaNeto = 0;
        $cont = 0;
        if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];
            $consumoremito = $ords['consumos'];
            $repuestos = array();            
            foreach ($consumos as $consumo) {
                $id1 = $consumo["idRep"];                
                $em1 = $this->getDoctrine()->getManager();
                $rep = $em1->getRepository('SistemaAdminBundle:Repvolvo')->find($id1);
                $rep->setCantidad($rep->getCantidad() - 1);
                $em1->persist($rep);
                $sumaNeto = $sumaNeto + $consumo['subtotal'];
                $str = $consumo['subtotal'];
                $fa = str_replace(".", ",", $str);
                $consumo['subtotal'] = $fa;
                $cont = $cont + 1;
                $repuestos[$cont]=$rep;
                $repuestos[0]=$rep;
            }
            //var_dump($ids[0]);
            for ($i = 0; $i <= $cont; $i++) {
//                var_dump($consumos[2]);die();                
                $consumos[$i] = new Renaultconsumo();
                $consumos[$i]->setidRepvolvo($repuestos[$i]);
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
                $operaciones[$i] = new \Sistema\AdminBundle\Entity\Renaultoperaciones();
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
                $terceros[$i] = new \Sistema\AdminBundle\Entity\Renaultterceros();
                $ord->addTerceros($terceros[$i]);                
            }
        }     
        
 
        $form = $this->createForm(new RenaultordenType(), $ord);        
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
 
            return $this->redirect($this->generateUrl('renaultorden_show', array('id' => $ord->getId())));   
        }
 
        return array(
            'form' => $form->createView()
        );
    }
    /**
     * Displays a form to edit an existing Renaultorden entity.
     *
     * @Route("/{id}/edit", name="renaultorden_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultorden entity.');
        }

        $editForm = $this->createForm(new RenaultordenType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Renaultorden entity.
     *
     * @Route("/{id}/update", name="renaultorden_update")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultorden:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultorden entity.');
        }

        $editForm   = $this->createForm(new RenaultordenType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('renaultorden_edit', array('id' => $id)));
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
     * Deletes a Renaultorden entity.
     *
     * @Route("/{id}/delete", name="renaultorden_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Renaultorden entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('renaultorden'));
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
     * @Route("/renaultrepuestos/stock", name="orden_renaultrepuestos_precio")
     */
    public function retornaPrecioRenaultrepuestos() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->findOneByCodigo($id);            
            return new Response($entity->getPrecio());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
    
     /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/renaultrepuestos/precio", name="orden_renaultrepuestos_stock")
     */
    public function retornaStockRenaultrepuestos() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->findOneByCodigo($id);            
            return new Response($entity->getCantidad());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
     /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/renaultrepuestos/nombre", name="orden_renaultrepuestos_nombre")
     */
    public function retornaNombreRenaultrepuestos() {
        $isAjax = $this->getRequest()->isXMLHttpRequest();
        if ($isAjax) {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultrepuestos')->findOneByCodigo($id);
            return new Response($entity->getId());
        }
        return new Response('Error. This is not ajax!', 400);
    }
    
         /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/reporte", name="renaultorden_imprimir")
     * @Template()
     */
    public function imprimirOrdenAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);        
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultorden entity.');
        }
        
        $contenido = $this->renderView('SistemaAdminBundle:Renaultorden:imprimirOrden.pdf.twig', array(
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

        return $this->get('sistema_tcpdf')->quick2_pdf($pdf);
    }
    
        /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/ordenexcel", name="renaultorden_imprimir_excel")
     * @Template()
     */
    public function imprimirOrdenExcelAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultorden entity.');
        }

        // Creamos un objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Leemos un archivo Excel 2007
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('pantilla_renault.xlsx');
        
        $fecha = $entity->getFecha()->format('d-m-Y');
        $fechafab = $entity->getFechafab()->format('d-m-Y');        
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
        $objPHPExcel->getActiveSheet()->SetCellValue('K9', $fechafab);
        $objPHPExcel->getActiveSheet()->SetCellValue('K10', $entity->getCam());
//        $objPHPExcel->getActiveSheet()->SetCellValue('J10', 'HS:');
//        $objPHPExcel->getActiveSheet()->SetCellValue('K10', $entity->getHs());
        
        $a=14;
        foreach ($entity->getSolicitudes() as $solicitud) {
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $solicitud->getDescripcion());
        $a++;
        }
        
        $b=22;
        foreach ($entity->getConsumos() as $consumo) {
        $precio=$consumo->getSubtotal()/$consumo->getCantidad();
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$b, $consumo->getCantidad());
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$b, $consumo->getIdRenaultrepuestos()->getCodigo());
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$b, $consumo->getIdRenaultrepuestos()->getDescripcion());
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
        $objPHPExcel->getActiveSheet()->getStyle('K9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        // Damos un borde a la celda
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $objPHPExcel->getActiveSheet()->getStyle('C14')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        //Guardamos el archivo en formato Excel 2007
        //Si queremos trabajar con Excel 2003, basta cambiar el ‘Excel2007′ por ‘Excel5′ y el nombre del archivo de salida cambiar su formato por ‘.xls’
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("Orden_renault".$id.".xlsx");
        return $this->redirect($this->generateUrl('renaultorden_show', array('id' => $id)));
    }
    
        /**
     * Edits an existing Ordvolvo entity.
     *
     * @Route("/{id}/generaremito", name="renaultorden_remito")     
     * @Template()
     */
    public function GenerarRemitoAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $ord = $em->getRepository('SistemaAdminBundle:Renaultorden')->find($id);
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
    $count=0;
    foreach ($ord->getConsumos() as $consumo) {
            if ($consumo->getIdRepvolvo()->getTipo() == 'volvo') {
                $originalCons[] = $consumo;
                $consremito = new \Sistema\AdminBundle\Entity\Renaultconsumo();
                $consremito->setCantidad($consumo->getCantidad());
                $consremito->setGarantia($consumo->getGarantia());
                $consremito->setIdRepvolvo($consumo->getIdRepvolvo());
                $consremito->setIdRepvolvo($consumo->getIdRepvolvo());
                $consremito->setRemitovolvo($rem);
                $consremito->setSubtotal($consumo->getSubtotal());
                $rem->addConsumosRenault($consremito);
                $count++;
            }
        }
    $originalOper= array();    
    foreach ($ord->getOperaciones() as $operacion) {
        $originalOper[] = $operacion;       
    }
    $originalTerc= array();    
    foreach ($ord->getTerceros() as $tercero) {
        $originalTerc[] = $tercero;       
    }
     
        if ($count != 0) {
            $rem->setCliente($ord->getCliente());
            $rem->setChasis($ord->getChasis());
            $rem->setCotizacion($ord->getCotizacion());
            $rem->setDominio($ord->getDominio());
            $rem->setFecha($ord->getFecha());
            $rem->setModelo($ord->getModelo());
            $rem->setNeto($ord->getNeto());
            $rem->setEnvia('María Antonella Pescarolo');
            //$rem->setConsumos($originalCons);
            $ord->setIdRemito($rem);
            $em->persist($rem);
            $em->persist($ord);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');
            return $this->redirect($this->generateUrl('remitovolvo_show', array('id' => $rem->getId())));
        }else{
            $this->get('session')->getFlashBag()->add('error', 'ERROR! NO TIENE CONSUMOS DE VOLVO');
            return $this->redirect($this->generateUrl('renaultorden_show', array('id' => $ord->getId())));
        }



//    return array(
//            'entity'      => $ord,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
        }
}
