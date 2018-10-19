<?php

namespace ApiBundle\Controller\Pub;

use ApiBundle\Form\EventParametersType;
use ApiBundle\Form\RegisterRequestType;
use BusinessBundle\Entity\Event;
use BusinessBundle\Entity\RegisterRequest;
use BusinessBundle\ValueObject\EventParameters;
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

class EventController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of publish events"
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
     *
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
     * @SWG\Parameter(
     *      name="industries",
     *      in="query",
     *      type="array",
     *  @SWG\Items(
     *      type="integer"
     *  )
     * ),
     * @SWG\Parameter(
     *      name="eventTopic",
     *      in="query",
     *      type="array",
     *  @SWG\Items(
     *      type="integer"
     *  )
     * ),
     * @SWG\Parameter(
     *      name="eventType",
     *      in="query",
     *      type="array",
     *  @SWG\Items(
     *      type="integer"
     *  )
     * ),
     * @SWG\Parameter(
     *      name="venue",
     *      in="query",
     *      type="array",
     *  @SWG\Items(
     *      type="string"
     *  )
     * ),
     * @Rest\QueryParam(name="eventDateFrom", strict=false,  nullable=true)
     * @Rest\QueryParam(name="eventDateTo", strict=false,  nullable=true)
     * @Rest\QueryParam(name="sortBy", allowBlank=false, default="date", description="Sort field")
     * @Rest\QueryParam(name="sortDir", requirements="(asc|desc)+", allowBlank=false, default="desc", description="Sort direction")
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false,  nullable=true)
     * @SWG\Tag(name="Public")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function listAction(Request $request, ParamFetcher $paramFetcher)
    {
        $currentRoute =  $request->get('_route');
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $context = new Context();

        try {
            $defaultLimit = $this->get('api.event_manager')->getDefaultLimit();
            $defaultOffset = $this->get('api.event_manager')->getDefaultOffset();
            $limit = (empty($paramFetcher->get('limit'))) ? $defaultLimit : $paramFetcher->get('limit');
            $offset = (empty($paramFetcher->get('offset'))) ? $defaultOffset : $paramFetcher->get('offset');

            $eventParameters =  new EventParameters();
            $form = $this->createForm(EventParametersType::class, $eventParameters, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $filterParams = $eventParameters->toArray();
            $customerRef = $request->headers->get('x-customer-ref');
            $query = $this->get('api.event_manager')->getEvents($filterParams, $customerRef, $currentRoute);

            $groups = ['event'];
            $context->setGroups($groups);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                (int)($offset / $limit) + 1,
                $limit
            );

            $events = $pagination->getItems();

            $response =[
                "totalItems" => $pagination->getTotalItemCount(),
                "items" => $events
            ];

            $view = $this->view($response, $responseCode);
            $view->setContext($context);

            return $this->handleView($view);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $events = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($events, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return an event by Id"
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
     * )
     * @SWG\Tag(name="Public")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getAction(Event $event = null, Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);

        if (null == $event){
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Resource not found');
        }

        if(!in_array($event->getStatus(), Event::PUBLIC_EVENT_STATUS_DISPLAY) || $event->getCustomerRef() != $request->headers->get('x-customer-ref')){
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Resource not found');
        }

        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Inscription request"
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
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="compagnyName",
     *             type="string",
     *         ),
     *        @SWG\Property(
     *             property="email",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="phoneNumber",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="city",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="country",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="reasonForAttending",
     *             type="string"
     *         )
     *     )
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
     * @SWG\Tag(name="Public")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function inscriptionRequestAction(Request $request, Event $event)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $registerRequest = new RegisterRequest();
        try {
            $form = $this->createForm(RegisterRequestType::class, $registerRequest, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $registerRequest->setEvent($event);
            $registerRequest->setStatus("request");
            $this->get('api.event_manager')->save($registerRequest);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $registerRequest = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $context = new Context();
        $groups = ['request_register'];
        $context->setGroups($groups);
        $view = $this->view($registerRequest, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }
}