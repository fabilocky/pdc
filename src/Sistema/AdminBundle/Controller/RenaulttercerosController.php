<?php

namespace Sistema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Sistema\AdminBundle\Entity\Renaultterceros;
use Sistema\AdminBundle\Form\RenaulttercerosType;
use Sistema\AdminBundle\Form\RenaulttercerosFilterType;

/**
 * Renaultterceros controller.
 *
 * @Route("/renaultterceros")
 */
class RenaulttercerosController extends Controller
{
    /**
     * Lists all Renaultterceros entities.
     *
     * @Route("/", name="renaultterceros")
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
        $filterForm = $this->createForm(new RenaulttercerosFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('SistemaAdminBundle:Renaultterceros')->createQueryBuilder('e');
    
        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('RenaulttercerosControllerFilter');
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
                $session->set('RenaulttercerosControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RenaulttercerosControllerFilter')) {
                $filterData = $session->get('RenaulttercerosControllerFilter');
                $filterForm = $this->createForm(new RenaulttercerosFilterType(), $filterData);
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
            return $me->generateUrl('renaultterceros', array('page' => $page));
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
     * Finds and displays a Renaultterceros entity.
     *
     * @Route("/{id}/show", name="renaultterceros_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultterceros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultterceros entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Renaultterceros entity.
     *
     * @Route("/new", name="renaultterceros_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Renaultterceros();
        $form   = $this->createForm(new RenaulttercerosType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Renaultterceros entity.
     *
     * @Route("/create", name="renaultterceros_create")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultterceros:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Renaultterceros();
        $request = $this->getRequest();
        $form    = $this->createForm(new RenaulttercerosType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('renaultterceros_show', array('id' => $entity->getId())));        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.create.error');
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Renaultterceros entity.
     *
     * @Route("/{id}/edit", name="renaultterceros_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultterceros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultterceros entity.');
        }

        $editForm = $this->createForm(new RenaulttercerosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Renaultterceros entity.
     *
     * @Route("/{id}/update", name="renaultterceros_update")
     * @Method("post")
     * @Template("SistemaAdminBundle:Renaultterceros:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SistemaAdminBundle:Renaultterceros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Renaultterceros entity.');
        }

        $editForm   = $this->createForm(new RenaulttercerosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('renaultterceros_edit', array('id' => $id)));
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
     * Deletes a Renaultterceros entity.
     *
     * @Route("/{id}/delete", name="renaultterceros_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SistemaAdminBundle:Renaultterceros')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Renaultterceros entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('renaultterceros'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
