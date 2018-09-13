<?php

namespace ApiBundle\Controller\Editor;

use Ee\EeCommonBundle\Exception\BusinessException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

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
    public function getEventsAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getOneEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function createEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
    public function updateEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function deleteEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function publishRequestEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
    public function publishEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function archiveEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function registrationEventAction()
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = ['content' => 'Fake data for test'];

        } catch(BusinessException $ex) {
            $logger->logInfo($ex->getMessage());
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
    }
}