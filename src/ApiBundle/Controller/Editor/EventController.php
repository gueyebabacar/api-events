<?php

namespace ApiBundle\Controller\Editor;

use ApiBundle\Form\EventParametersType;
use ApiBundle\Form\EventType;
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
     *     description="Return list of events",
     *     @SWG\Items(ref=@Model(type=Event::class, groups={"event"}))
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
     * @Rest\QueryParam(name="eventDateFrom", strict=false,   nullable=true)
     * @Rest\QueryParam(name="eventDateTo", strict=false,   nullable=true)
     * @Rest\QueryParam(name="sortBy", allowBlank=false, default="date", description="Sort field")
     * @Rest\QueryParam(name="sortDir", requirements="(asc|desc)+", allowBlank=false, default="desc", description="Sort direction")
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false, nullable=true)
     * @SWG\Tag(name="Editor")
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
     * @SWG\Tag(name="Editor")
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

        if(!in_array($event->getStatus(), Event::EDITOR_EVENT_STATUS_DISPLAY) || $event->getCustomerRef() != $request->headers->get('x-customer-ref')){
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Resource not found');
        }

        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
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
     *         ),
     *        @SWG\Property(
     *             property="date",
     *             type="string",
     *             example="2018-10-11 16:03:09"
     *         ),
     *        @SWG\Property(
     *             property="detailedDescription",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="website",
     *             type="string",
     *             example="http://www.google.fr/"
     *         ),
     *        @SWG\Property(
     *             property="country",
     *             type="string",
     *             example="USA"
     *         ),
     *         @SWG\Property(
     *             property="venue",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="city",
     *             type="string"
     *        ),
     *        @SWG\Property(
     *             property="industries",
     *             type="array",
     *             collectionFormat="multi",
     *             @SWG\Items(
     *                 type="integer",
     *            )
     *         ),
     *        @SWG\Property(
     *             property="eventTopic",
     *             type="array",
     *             collectionFormat="multi",
     *             @SWG\Items(
     *                 type="integer",
     *            )
     *        ),
     *        @SWG\Property(
     *             property="eventType",
     *             type="array",
     *             collectionFormat="multi",
     *             @SWG\Items(
     *                 type="integer",
     *            )
     *        ),
     *        @SWG\Property(
     *             property="nameOfOrganizer",
     *             type="string"
     *        ),
     *        @SWG\Property(
     *             property="attachment",
     *             type="string",
     *             example="http://path/file.pdf"
     *        ),
     *        @SWG\Property(
     *             property="socialMediaSharing",
     *             type="array",
     *             collectionFormat="multi",
     *             @SWG\Items(
     *                 type="string",
     *            )
     *       ),
     *       @SWG\Property(
     *           property="contactForm",
     *           type="string",
     *           example="email@domain.com"
     *       ),
     *       @SWG\Property(
     *             property="visuel",
     *             type="array",
     *             example={
     *                 "type": "string",
     *                 "uri": "string"
     *             },
     *            @SWG\Items(
     *                 type="object",
     *                 @SWG\Property(property="key", type="string"),
     *                 @SWG\Property(property="value", type="string")
     *             )
     *        ),
     *      @SWG\Property(
     *          property="illustrations",
     *          type="array",
     *          collectionFormat="multi",
     *        @SWG\Items(
     *           type="object",
     *           @SWG\Property(property="type", type="string"),
     *           @SWG\Property(property="uri", type="string")
     *         )
     *       )
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
        $event = new Event();
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $event->setStatus("draft");
            $event->setCustomerRef($request->headers->get('x-customer-ref'));
            $this->get('api.event_manager')->save($event);

        }catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $event = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Update an event"
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
     *             property="customerRef",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="date",
     *             type="string",
     *             example="2018-10-11 16:03:09"
     *         ),
     *        @SWG\Property(
     *             property="detailedDescription",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="website",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="country",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="location",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="city",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="typeOfEvent",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="industry",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="thematicTag",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="nameOfOrganizer",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="attachment",
     *             type="string"
     *        ),
     *        @SWG\Property(
     *             property="socialMediaSharing",
     *             type="array",
     *             collectionFormat="multi",
     *             @SWG\Items(
     *                 type="string",
     *            )
     *       ),
     *       @SWG\Property(
     *           property="contactForm",
     *           type="string"
     *       ),
     *       @SWG\Property(
     *           property="status",
     *           type="string"
     *      )
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
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function updateAction(Request $request, Event $event)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.event_manager')->save($event);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $event = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($event, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Delete an event"
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
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function deleteAction(Event $event = null)
    {
        $responseCode = Response::HTTP_NO_CONTENT;
        $context = new Context();

        if (empty($event)){
            throw new HttpException(Response::HTTP_NOT_FOUND,'Resource not found');
        }
        if ($event->getStatus() != Event::DELETE_STATUS){
            throw new HttpException(Response::HTTP_NOT_FOUND,'Resource\'s status is not draft');
        }
        $this->get('api.event_manager')->remove($event);
        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Event's publish request"
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
     *     description="Technical error",
     *
     * ),
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="status",
     *             type="string",
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
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function publishRequestAction(Request $request, Event $event)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.event_manager')->save($event);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $event = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($event, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Publish an Event"
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
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="status",
     *             type="string",
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
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function publishAction(Request $request, Event $event)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.event_manager')->save($event);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $event = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Archive an Event"
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
     *     description="Technical error",
     *
     * ),
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="status",
     *             type="string",
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
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function archiveAction(Request $request, Event $event)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.event_manager')->save($event);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $event = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($event, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of registrations on an event"
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
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("registerRequest", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function registrationAction(RegisterRequest $registerRequest)
    {
        $responseCode = Response::HTTP_OK;
        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($registerRequest, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }
}