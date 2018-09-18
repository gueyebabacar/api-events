<?php

namespace ApiBundle\Controller\Pub;

use ApiBundle\Form\RegisterRequestType;
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
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true, description="number of result")
     * @Rest\QueryParam(name="offset", strict=false,  nullable=true, description="result page start")
     * @SWG\Tag(name="Public")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getEventsAction(ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = $this->get('api.event_manager')->getEvents($paramFetcher);

        } catch(BusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
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
     * @SWG\Tag(name="Public")
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
     *
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
     *         ),
     *         @SWG\Property(
     *             property="status",
     *             type="string"
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
            $this->get('api.event_manager')->save($registerRequest);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $registerRequest = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($registerRequest, $responseCode);
    }
}