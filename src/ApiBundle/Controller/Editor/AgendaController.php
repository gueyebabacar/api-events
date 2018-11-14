<?php

namespace ApiBundle\Controller\Editor;


use ApiBundle\Form\AgendaType;
use BusinessBundle\Entity\Agenda;

use Ee\EeCommonBundle\Exception\BusinessException;
use Ee\EeCommonBundle\Service\Validation\Form\FormBusinessException;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;


class AgendaController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of Agendas",
     *     @SWG\Items(ref=@Model(type=Agenda::class, groups={"event"}))
     * ),
     * @SWG\Response(
     *     response=403,
     *     description="Forbidden",
     *     examples={
     *          "invalid username/password":{
     *              "message": "Invalid credentials."
     *          },
     *          "Invalid customer ref/scope":{
     *              "message": "Access Denied"
     *          },
     *     }
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Technical error",
     * ),
     * @SWG\Parameter(
     *      name="X-CUSTOMER-REF",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="X-SCOPE",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="login",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="password",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false, nullable=true)
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function listAction(Request $request, ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);
        $paginator  = $this->get('knp_paginator');
        $defaultLimit = $this->get('api.agenda_manager')->getDefaultLimit();
        $defaultOffset = $this->get('api.agenda_manager')->getDefaultOffset();
        $limit = (empty($paramFetcher->get('limit'))) ? $defaultLimit : $paramFetcher->get('limit');
        $offset = (empty($paramFetcher->get('offset'))) ? $defaultOffset : $paramFetcher->get('offset');

        try {
            $customerRef = $request->headers->get('x-customer-ref');

            $query = $this->get('api.agenda_manager')->getAgendas($customerRef);
            $pagination = $paginator->paginate(
                $query,
                (int)($offset / $limit) + 1,
                $limit
            );

            $agendas = $pagination->getItems();

            $response =[
                "totalItems" => $pagination->getTotalItemCount(),
                "items" => $agendas
            ];

            $view = $this->view($response, $responseCode);
            $view->setContext($context);

            return $this->handleView($view);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $agendas = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($agendas, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Create an event"
     * ),
     * @SWG\Response(
     *     response=403,
     *     description="Forbidden",
     *     examples={
     *          "invalid username/password":{
     *              "message": "Invalid credentials."
     *          },
     *          "Invalid customer ref/scope":{
     *              "message": "Access Denied"
     *          },
     *     }
     * ),
     * @SWG\Response(
     *     response=500,
     *     description="Technical error"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="title",
     *             type="string"
     *         )
     *    )
     * ),
     * @SWG\Parameter(
     *      name="X-CUSTOMER-REF",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="X-SCOPE",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="login",
     *      in="header",
     *      type="string",
     *      required=true,
     * ),
     * @SWG\Parameter(
     *      name="password",
     *      in="header",
     *      type="string",
     *      required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $context = new Context();
        $logger = $this->get('ee.app.logger');
        $agenda = new Agenda();
        try {
            $form = $this->createForm(AgendaType::class, $agenda, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $agenda->setCustomerRef($request->headers->get('x-customer-ref'));
            $this->get('app_logger')->logInfo('Agenda creation', ['Title' => $agenda->getTitle()]);
            $this->get('api.agenda_manager')->save($agenda);

        }catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $agenda = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($agenda, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }
}