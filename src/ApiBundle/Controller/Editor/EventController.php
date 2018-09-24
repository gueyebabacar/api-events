<?php

namespace ApiBundle\Controller\Editor;

use ApiBundle\Form\EventType;
use BusinessBundle\Entity\Event;
use BusinessBundle\Entity\RegisterRequest;
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


class EventController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of events"
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @Rest\QueryParam(name="date", strict=false,  nullable=true)
     * @Rest\QueryParam(name="status", strict=false,  nullable=true)
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false,  nullable=true)
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function listAction(ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = $this->get('api.event_manager')->getEvents($paramFetcher);

        } catch(BusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }
        $context = new Context();
        $groups = ['event'];
        $context->setGroups($groups);
        $view = $this->view($data, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
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
     *
     * ),
     * @SWG\Parameter(
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getOneEventAction(Event $event)
    {
        $responseCode = Response::HTTP_OK;

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
     *             property="customerRef",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *        @SWG\Property(
     *             property="date",
     *             type="datetime",
     *             example="12/12/2018"
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
     *          property="visuel",
     *          type="array",
     *          example={
     *                "type": "visuel type",
     *                "uri": "visuel path"
     *          },
     *         @SWG\Items(
     *           type="object",
     *           @SWG\Property(property="key", type="string"),
     *           @SWG\Property(property="value", type="string")
     *         )
     *       ),
     *       @SWG\Property(
     *          property="illustrations",
     *          type="array",
     *          collectionFormat="multi",
     *          @SWG\Items(
     *              type="string",
     *          )
     *       )
     *    )
     * ),
     * @SWG\Parameter(
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function createEventAction(Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $event = new Event();
        try {
            $form = $this->createForm(EventType::class, $event, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $event->setStatus("draft");
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
     *
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
     *             type="datetime",
     *             example="12/12/2018"
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function updateEventAction(Request $request, Event $event)
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("event", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function deleteEventAction(Event $event)
    {
        $this->get('api.event_manager')->remove($event);

        return $this->view($event, Response::HTTP_NO_CONTENT);
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function publishRequestEventAction(Request $request, Event $event)
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function publishEventAction(Request $request, Event $event)
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function archiveEventAction(Request $request, Event $event)
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
     *  name="X-CUSTOMER-REF",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="X-SCOPE",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="login",
     *  in="header",
     *  type="string",
     *  required=true,
     * ),
     * @SWG\Parameter(
     *  name="password",
     *  in="header",
     *  type="string",
     *  required=true,
     * )
     * @SWG\Tag(name="Editor")
     * @ParamConverter("registerRequest", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function registrationEventAction(RegisterRequest $registerRequest)
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