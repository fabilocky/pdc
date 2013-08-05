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
use Sistema\AdminBundle\Form\PresupuestoType;
use Sistema\AdminBundle\Form\LiquidacionType;
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
use \PHPExcel_Style_Fill;

/**
 * Ordvolvo controller.
 *
 * @Route("/ordvolvo")
 */
class OrdvolvoController extends Controller {

    /**
     * Lists all Ordvolvo entities.
     *
     * @Route("/", name="ordvolvo")
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
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        $consumos = $entity->getConsumos();
        foreach ($consumos as $consumo) {
            $hola = $consumo->getRemitovolvo();
            //var_dump($hola);die();
            //$num=$hola->getId();
            //var_dump($num);die();
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        if ($num = NULL) {
            $num = 0;
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'num' => $num,
        );
    }

    /**
     * Displays a form to create a new OrdVolvo entity.
     *
     * @Route("/new", name="new_ordvolvo")
     * @Template()
     */
    public function newAction() {
        $ord = new Ordvolvo();     
        $data = file_get_contents("https://hb.bbv.com.ar/fnet/mod/inversiones/NL-dolareuro.jsp");        
        utf8_encode($data);
        preg_match("/<table.*?>.*?<\/[\s]*table>/s", $data, $table_html);

  // Get title for each row
  preg_match_all("/<th.*?>(.*?)<\/[\s]*th>/", $table_html[0], $matches);
  $row_headers = $matches[1];

  // Iterate each row
  preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  $table = array();

  foreach($matches[1] as $row_html)
  {
    preg_match_all("/<td.*?>(.*?)<\/[\s]*td>/", $row_html, $td_matches);
    $row = array();
    for($i=0; $i<count($td_matches[1]); $i++)
    {
      $td = strip_tags(html_entity_decode($td_matches[1][$i]));
      $row[$row_headers[$i]] = $td;
    }

    if(count($row) > 0)
      $table[] = $row;
  }       
        $valores= array();
        foreach ($table[0] as $valor) {
           $valores[]= $valor;
        }        
        if ($valores[2]){
        $str = $valores[2];
        $fa=str_replace(",", ".",$str);
        }
        else{
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
    public function createAction(Request $request) {
        $ord = new Ordvolvo();
        //$rem = new \Sistema\AdminBundle\Entity\Remitovolvo();
        $ords = $request->request->get('ordvolvo', array());
        $cliente = $ords['client'];
        if (isset($ords['solicitudes'])) {
            $solicitudes = $ords['solicitudes'];
            foreach ($solicitudes as $solicitud) {
                $solicitud = new Solicrep();
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
                $consumos[$i] = new Consumo();
                $consumos[$i]->setidRepvolvo($repuestos[$i]);
                $ord->addConsumos($consumos[$i]);
            }
        }

        $cont1 = 0;
        if (isset($ords['operaciones'])) {
            $operaciones = $ords['operaciones'];
//            var_dump($operaciones);die();
            foreach ($operaciones as $operacion) {
                $str1 = $operacion['hs'];
                $fa1 = str_replace(".", ",", $str1);
                $operacion['hs'] = $fa1;
                $str2 = $operacion['subtotal'];
                $fa2 = str_replace(".", ",", $str2);
                $operacion['subtotal'] = $fa2;
                $cont1 = $cont1 + 1;
            }
            for ($i = 0; $i <= $cont1; $i++) {
                $operaciones[$i] = new Operaciones();
                $ord->addOperaciones($operaciones[$i]);
            }
        }

        $cont2 = 0;
        if (isset($ords['terceros'])) {
            $terceros = $ords['terceros'];
            foreach ($terceros as $tercero) {
                $str3 = $tercero['unitario'];
                $fa3 = str_replace(".", ",", $str3);
                $tercero['unitario'] = $fa3;
                $str4 = $tercero['subtotal'];
                $fa4 = str_replace(".", ",", $str4);
                $tercero['subtotal'] = $fa4;
                $cont2 = $cont2 + 1;
            }
            for ($i = 0; $i <= $cont2; $i++) {
                $terceros[$i] = new Terceros();
                $ord->addTerceros($terceros[$i]);
            }
        }
        $cont3 = 0;
        if (isset($ords['otro'])) {
            $otro = $ords['otro'];
            foreach ($otro as $otro) {
                $str3 = $otro['precio'];
                $fa3 = str_replace(".", ",", $str3);
                $otro['precio'] = $fa3;
                $str4 = $otro['subtotal'];
                $fa4 = str_replace(".", ",", $str4);
                $otro['subtotal'] = $fa4;
                $cont2 = $cont2 + 1;
            }
            for ($i = 0; $i <= $cont3; $i++) {
                $otro[$i] = new Otro();
                $ord->addOtro($otro[$i]);
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
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        $editForm = $this->createForm(new OrdvolvoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
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
    public function editarAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $ord = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
        $deleteForm = $this->createDeleteForm($id);

        if (!$ord) {
            throw $this->createNotFoundException('No ord found for is ' . $id);
        }
        $originalSolic = array();
        foreach ($ord->getSolicitudes() as $solicitud) {
            $originalSolic[] = $solicitud;
        }
        $originalCons = array();
        foreach ($ord->getConsumos() as $consumo) {
            $originalCons[] = $consumo;
        }
        $originalOper = array();
        foreach ($ord->getOperaciones() as $operacion) {
            $originalOper[] = $operacion;
        }
        $originalTerc = array();
        foreach ($ord->getTerceros() as $tercero) {
            $originalTerc[] = $tercero;
        }

        $editForm = $this->createForm(new OrdvolvoType(), $ord);

        $ords = $request->request->get('ordvolvo', array());
        if (isset($ords['solicitudes'])) {
            $solicitudes = $ords['solicitudes'];
            $i = 0;
            foreach ($originalSolic as $solicitud) {
                $solicitud->setDescripcion($solicitudes[$i]['descripcion']);
                $em->persist($solicitud);
                $i++;
            }
        }
        if (isset($ords['operaciones'])) {
            $operaciones = $ords['operaciones'];
            $i = 0;
            foreach ($originalOper as $operacion) {
                $operacion->setDenominacion($operaciones[$i]['denominacion']);
                $operacion->setHs($operaciones[$i]['hs']);
                $operacion->setSubtotal($operaciones[$i]['subtotal']);
                $em->persist($operacion);
                $i++;
            }
        }
        if (isset($ords['consumos'])) {
            $consumos = $ords['consumos'];
            $i = 0;
            foreach ($originalCons as $consumo) {
//                $consumo=new Consumo();
                $id1 = $consumos[$i]['idRepvolvo'];
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
            'entity' => $ord,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ordvolvo entity.
     *
     * @Route("/{id}/delete", name="ordvolvo_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
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

    private function createDeleteForm($id) {
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
            if ($entity){
            return new Response($entity->getPrecio());
            }else return '';
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
            if ($entity){
            return new Response($entity->getCantidad());
            }else return '';
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
            if ($entity){
            return new Response($entity->getDescripcion());
            }else return '';
        }
        return new Response('Error. This is not ajax!', 400);
    }

    /**
     * Finds and displays a precio Tipo Producto entity.
     *
     * @Route("/repvolvo/id", name="orden_repvolvo_id")
     */
    public function retornaIdRepvolvo() {
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
    public function ajaxMemberAction(Request $request) {
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
    public function ajaxAction(Request $request) {
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
    public function ejemplolessAction() {
        return array();
    }

    /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/{id}/reporte", name="orden_imprimir")
     * @Template()
     */
    public function imprimirOrdenAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirOrden.pdf.twig', array(
            'entity' => $entity,
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
     * REPORTE
     * 
     * @Route("/{id}/remito", name="remito_imprimir")
     * @Template()
     */
    public function imprimirRemitoAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ordvolvo entity.');
        }

        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirRemito.pdf.twig', array(
            'entity' => $entity,
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

        $a = 14;
        foreach ($entity->getSolicitudes() as $solicitud) {
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $a, $solicitud->getDescripcion());
            $a++;
        }

        $b = 22;
        foreach ($entity->getConsumos() as $consumo) {
            $precio = $consumo->getSubtotal() / $consumo->getCantidad();
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $b, $consumo->getCantidad());
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $b, $consumo->getIdRepvolvo()->getCodigo());
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $b, $consumo->getIdRepvolvo()->getDescripcion());
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $b, $precio);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $b, $consumo->getSubtotal());
            $b++;
        }

        $c = 34;
        foreach ($entity->getOperaciones() as $operacion) {
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $c, $operacion->getDenominacion());
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $c, $operacion->getHs());
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $c, $operacion->getSubtotal());
            $c++;
        }

        $d = 43;
        foreach ($entity->getTerceros() as $tercero) {
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $d, $tercero->getCantidad());
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $d, $tercero->getCantidad());
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $d, $tercero->getDenominacion());
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $d, $tercero->getUnitario());
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $d, $tercero->getSubtotal());
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
        $objWriter->save("Orden_volvo" . $id . ".xlsx");
        return $this->redirect($this->generateUrl('ordvolvo_show', array('id' => $id)));
    }

    /**
     * @Route("/excel", name="excel")
     * @Template()
     */
    public function excelAction($name = "hola") {

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
    public function verArticulosAction() {
        return $this->render('SistemaAdminBundle:Cliente:new.html.twig', array());
    }

    /**
     * Edits an existing Ordvolvo entity.
     *
     * @Route("/{id}/generaremito", name="ordvolvo_remito")     
     * @Template()
     */
    public function GenerarRemitoAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $ord = $em->getRepository('SistemaAdminBundle:Ordvolvo')->find($id);
        //$deleteForm = $this->createDeleteForm($id);
        $rem = new \Sistema\AdminBundle\Entity\Remitovolvo();

        if (!$ord) {
            throw $this->createNotFoundException('No ord found for is ' . $id);
        }
        $originalSolic = array();
        foreach ($ord->getSolicitudes() as $solicitud) {
            $originalSolic[] = $solicitud;
        }
        $originalCons = array();
        foreach ($ord->getConsumos() as $consumo) {
            $originalCons[] = $consumo;
            $consremito = new Consumo();
            $consremito->setCantidad($consumo->getCantidad());
            $consremito->setGarantia($consumo->getGarantia());
            $consremito->setIdRepvolvo($consumo->getIdRepvolvo());
            $consremito->setRemitovolvo($rem);
            $consremito->setSubtotal($consumo->getSubtotal());
            $rem->addConsumos($consremito);
        }
        $originalOper = array();
        foreach ($ord->getOperaciones() as $operacion) {
            $originalOper[] = $operacion;
        }
        $originalTerc = array();
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

    /**
     * @Route("/liquidacion", name="liquidacion")
     * @Template()
     */
    public function LiquidacionAction() {
        $form = $this->createForm(new LiquidacionType());

        return $this->render('SistemaAdminBundle:Ordvolvo:liquidacion.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/reporteliquidacion", name="reporteliquidacion")
     * @Method("post")
     * @Template()
     */
    public function ReporteliquidacionAction(Request $request) {
        $ords = $request->request->get('liquidacion', array());
        $fecha1 = $ords['fecha1'];
        $fecha2 = $ords['fecha2'];
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
                        'SELECT p FROM SistemaAdminBundle:Ordvolvo p WHERE p.fecha >= :fecha1 AND p.fecha <= :fecha2'
                )->setParameter('fecha1', $fecha1)
                 ->setParameter('fecha2', $fecha2);

        $ordenes = $query->getResult();                
        
        $em1 = $this->getDoctrine()->getEntityManager();
        $query1 = $em1->createQuery(
                        'SELECT p FROM SistemaAdminBundle:Remitovolvo p WHERE p.fecha >= :fecha1 AND p.fecha <= :fecha2'
                )->setParameter('fecha1', $fecha1)
                 ->setParameter('fecha2', $fecha2);

        $remitos = $query1->getResult();
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirLiquidacion.pdf.twig', array(
            'entity' => $ordenes,
            'remitos' => $remitos,
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
     * LIQUIDACION MENSUAL
     * 
     * @Route("/liquidacionexcel", name="liquidacion_imprimir_excel")
     * @Template()
     */
    public function imprimirLiquidacionExcelAction(Request $request) {
       $ords = $request->request->get('liquidacion', array());
        $fecha1 = $ords['fecha1'];
        $fecha2 = $ords['fecha2'];
        $separa = explode('-', $fecha1);
        $mes=$separa[1];
        $periodo= $this->DevuelveMes($mes);        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
                        'SELECT p FROM SistemaAdminBundle:Ordvolvo p WHERE p.fecha >= :fecha1 AND p.fecha <= :fecha2'
                )->setParameter('fecha1', $fecha1)
                 ->setParameter('fecha2', $fecha2);

        $ordenes = $query->getResult();                
        
        $em1 = $this->getDoctrine()->getEntityManager();
        $query1 = $em1->createQuery(
                        'SELECT p FROM SistemaAdminBundle:Remitovolvo p WHERE p.fecha >= :fecha1 AND p.fecha <= :fecha2'
                )->setParameter('fecha1', $fecha1)
                 ->setParameter('fecha2', $fecha2);

        $remitos = $query1->getResult();
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirLiquidacion.pdf.twig', array(
            'entity' => $ordenes,
            'remitos' => $remitos,
        ));
        

        // Creamos un objeto PHPExcel
        $objPHPExcel = new PHPExcel();       
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('plantilla_liquidacion.xlsx');        
        $objPHPExcel->setActiveSheetIndex(0);
        $styleArray = array(            
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),            
        );
        $alineacion = array('alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $negrita = array(
            'font' => array(
                'bold' => true,
                'name' => 'Calibri',
                'size' => '11',
                'Alignement' => 'center',
            ),            
        );
        $fuente = array(
            'font' => array(                
                'name' => 'Calibri',
                'size' => '11',
                'Alignement' => 'center',
            ),            
        );
        $numeros = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '045FB4',
                ),
            ),
        );
        $estiloneto = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '81F7D8',
                ),
            ),
        );
        $estilototal = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'FFFF00',
                ),
            ),
        );
        $fuentetot = array(
            'font' => array(
                'bold' => TRUE,
                'italic' => TRUE,
                'name' => 'Calibri',
                'size' => '14',
                'Alignement' => 'center',
            ),            
        );
        $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($numeros);
        $objPHPExcel->getActiveSheet()->SetCellValue('G4', 'LIQUIDACIONES MES DE '.$periodo);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($negrita);        
        $a = 7;
        $totmo=0;
        $toter=0;
        $totporc=0;
        //ORDENES
        $primeraorden=$ordenes[0]->getId();
        $ultimaorden=  $ordenes[(count($ordenes)-1)]->getId();
        $primerremito=$remitos[0]->getId();
        $ultimoremito=  $remitos[(count($remitos)-1)]->getId();
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'ORDENES '.$primeraorden.' --> '.$ultimaorden.' Y REMITOS '.$primerremito.' --> '.$ultimoremito);
        $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($fuente);
        foreach ($ordenes as $orden) {
            $cotizacion=$orden->getCotizacion();
            $repctacte=0;
            $mo=0;
            $ter=0;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $a, $orden->getId());
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $a, $orden->getCliente()->getNombre());
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $a, $orden->getFecha()->format('d-m-Y'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $a, $orden->getChasis());
            foreach ($orden->getConsumos() as $consumo) {                
                $repctacte+=$cotizacion * $consumo->getIdRepvolvo()->getPrecio();                
            }
            $repctacte=number_format($repctacte, 2);
            $porc=$repctacte*0.15;
            $porc=number_format($porc, 2);            
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $a, $repctacte);
            foreach ($orden->getOperaciones() as $operacion) {                
                $mo+=$operacion->getSubtotal();
            }
            $totmo+=$mo;
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $a, $mo);
            foreach ($orden->getTerceros() as $tercero) {                
                $ter+=$tercero->getSubtotal();
            }
            $toter+=$ter;
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $a, $ter);
            $totporc+=$porc;
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $porc);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a.':I' . $a)->applyFromArray($fuente);            
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($numeros);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
            $a++;
        }
        //REMITOS
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $a, 'REMITOS');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($negrita);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($alineacion);
        $a++;        
        $totreppdc=0;
        foreach ($remitos as $remito) {
            $cotizacion=$remito->getCotizacion();
            $repctacter=0;
            $reppdc=0;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $a, $remito->getId());            
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $a, $remito->getFecha()->format('d-m-Y'));            
            foreach ($remito->getConsumosRenault() as $consumo) {                
                $reppdc+=$cotizacion * $consumo->getIdRepvolvo()->getPrecio();
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $a, $reppdc);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $a, 'PESCAROLO DIESEL CENTER');                
            }
            foreach ($remito->getConsumosPdc() as $consumo) {                
                $reppdc+=$cotizacion * $consumo->getIdRepvolvo()->getPrecio();
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $a, $reppdc);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $a, 'PESCAROLO DIESEL CENTER');                
            }
            foreach ($remito->getConsumos() as $consumo) {
                $repctacter+=$cotizacion * $consumo->getIdRepvolvo()->getPrecio();
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $a, $repctacter);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $repctacter*0.15);
                $totporc+=$repctacter*0.15;
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $a, $remito->getCliente());
            }
            $totreppdc+=$reppdc;
            $reppdc=number_format($reppdc, 2);          
//            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $a, $reppdc);           
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a.':I' . $a)->applyFromArray($fuente);
            
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($numeros);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $a)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
            $a++;
        }
         
        //Sumatoria Ordenes
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $a, $totmo);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $a, $toter);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $totporc);        
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a.':I' . $a)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a.':I' . $a)->getFill()->getStartColor()
                ->setARGB('04B404');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a.':I' . $a)->applyFromArray($fuente);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $a)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
        //Sumatoria Remitos
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $a, $totreppdc);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $a)->applyFromArray($styleArray);
         $objPHPExcel->getActiveSheet()->getStyle('E' . $a)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $a)->getFill()->getStartColor()
                ->setARGB('FF0000');
        $a++;
        //TOTALES
        $neto= $toter+$totmo+$totporc-$totreppdc;
        $iva=$neto * 0.15; 
        $iva=number_format($iva, 2);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $a, 'NETO $');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($alineacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $neto);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($alineacion);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($estiloneto);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
        $a++;
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $a, 'IVA $');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($alineacion);
        
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $iva);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($alineacion);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($estiloneto);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
        $a++;
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $a, 'TOTAL $');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($alineacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $a, $neto + $iva);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($fuentetot);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($alineacion);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($estilototal);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($styleArray);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("Liquidacion_" . $periodo. ".xlsx");
        $this->get('session')->getFlashBag()->add('success', 'liquidacion generada en el directorio web');
        return $this->redirect($this->generateUrl('liquidacion'));
    }
    
    public function DevuelveMes($mes){
        switch ($mes){
            case 01:
                return 'ENERO';
        break;
    case 02:
        return 'FEBRERO';
        break;
    case 03:
        return 'MARZO';
        break;
     case 04:
        return 'ABRIL';
        break;
     case 05:
        return 'MAYO';
        break;
     case 06:
        return 'JUNIO';
        break;
     case 07:
        return 'JULIO';
        break;
     case 08:
        return 'AGOSTO';
        break;
     case 09:
        return 'SEPTIEMBRE';
        break;
     case 10:
        return 'OCTUBRE';
        break;
     case 11:
        return 'NOVIEMBRE';
        break;
     case 12:
        return 'DICIEMBRE';
        break;
        }
        
    }
    
    /**
     * Displays a form to create a new OrdVolvo entity.
     *
     * @Route("/presupuesto", name="presupuesto")
     * @Template()
     */
    public function PresupuestoAction() {
        $ord = new Ordvolvo();     
        $data = file_get_contents("https://hb.bbv.com.ar/fnet/mod/inversiones/NL-dolareuro.jsp");        
        utf8_encode($data);
        preg_match("/<table.*?>.*?<\/[\s]*table>/s", $data, $table_html);

  // Get title for each row
  preg_match_all("/<th.*?>(.*?)<\/[\s]*th>/", $table_html[0], $matches);
  $row_headers = $matches[1];

  // Iterate each row
  preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  $table = array();

  foreach($matches[1] as $row_html)
  {
    preg_match_all("/<td.*?>(.*?)<\/[\s]*td>/", $row_html, $td_matches);
    $row = array();
    for($i=0; $i<count($td_matches[1]); $i++)
    {
      $td = strip_tags(html_entity_decode($td_matches[1][$i]));
      $row[$row_headers[$i]] = $td;
    }

    if(count($row) > 0)
      $table[] = $row;
  }       
        $valores= array();
        foreach ($table[0] as $valor) {
           $valores[]= $valor;
        }        
        if ($valores[2]){
        $str = $valores[2];
        $fa=str_replace(",", ".",$str);
        }
        else{
            $fa=0;
        }

        $form = $this->createForm(new PresupuestoType(), $ord);
 
        return $this->render('SistemaAdminBundle:Ordvolvo:newpresupuesto.html.twig', array(
            'form' => $form->createView(),
            'dolar'=> $fa,
        ));
    }    
    
    /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/presupuestoimprimir", name="presupuesto_imprimir")
     * @Method("post")
     * @Template()
     */
    public function imprimirPresupuestoAction(Request $request) {
       $ords = $request->request->get('ordvolvo', array());
//       var_dump($ords);die();
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirPresupuesto.pdf.twig', array(
            'entity' => $ords,
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

        return $this->get('sistema_tcpdf')->quick3_pdf($pdf);
    }
    
    /**
     * Displays a form to create a new OrdVolvo entity.
     *
     * @Route("/pedido", name="pedido")
     * @Template()
     */
    public function PedidoAction() {
        $ord = new Ordvolvo();     
        

        $form = $this->createForm(new \Sistema\AdminBundle\Form\PedidoType(), $ord); 
        return $this->render('SistemaAdminBundle:Ordvolvo:newpedido.html.twig', array(
            'form' => $form->createView(),           
        ));
    }    
    
    /**
     * REPORTE DE TORNEO GRUPO EQUIPOS
     * 
     * @Route("/pedidoimprimir", name="pedido_imprimir")
     * @Method("post")
     * @Template()
     */
    public function imprimirPedidoAction(Request $request) {
       $ords = $request->request->get('ordvolvo', array());
//       var_dump($ords);die();
        $contenido = $this->renderView('SistemaAdminBundle:Ordvolvo:imprimirPedido.pdf.twig', array(
            'entity' => $ords,
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

        return $this->get('sistema_tcpdf')->quick3_pdf($pdf);
    }

}
