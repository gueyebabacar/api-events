<?php

namespace ApiBundle\Controller\Admin;

use ApiBundle\Form\AppClientType;
use ApiSecurityBundle\Entity\AppClient;
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


class AppController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of authorized apps"
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
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false,  nullable=true)
     * @SWG\Tag(name="Admin")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getAuthorizedAppsAction(ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = $this->get('api.app_manager')->getApps($paramFetcher);

        } catch(BusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($data, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Create an application"
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
     *             property="login",
     *             type="string",
     *         ),
     *         @SWG\Property(
     *             property="pwd",
     *             type="string",
     *         ),
     *        @SWG\Property(
     *             property="enable",
     *             type="boolean",
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
     * @SWG\Tag(name="Admin")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function createAppAction(Request $request)
    {
        $passwordEncoder = $this->get('security.password_encoder');
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $appClient = new AppClient();
        try {
            $form = $this->createForm(AppClientType::class, $appClient, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $password = $passwordEncoder->encodePassword($appClient, $appClient->getPassword());
            $appClient->setPwd($password);
            $this->get('api.app_manager')->save($appClient);

        }catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $appClient = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($appClient, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Update an application"
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
     *             property="login",
     *             type="string",
     *         ),
     *         @SWG\Property(
     *             property="pwd",
     *             type="string",
     *         ),
     *        @SWG\Property(
     *             property="enable",
     *             type="boolean",
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
     * @SWG\Tag(name="Admin")
     * @ParamConverter("appClient", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function updateAppAction(Request $request, AppClient $appClient)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $passwordEncoder = $this->get('security.password_encoder');
        try {
            $form = $this->createForm(AppClientType::class, $appClient, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $password = $passwordEncoder->encodePassword($appClient, $appClient->getPassword());
            $appClient->setPwd($password);
            $this->get('api.app_manager')->save($appClient);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $appClient = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($appClient, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return an application by Id"
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
     * @SWG\Tag(name="Admin")
     * @ParamConverter("appClient", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function getOneAppAction(AppClient $appClient)
    {
        $responseCode = Response::HTTP_OK;
        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($appClient, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Enable an application"
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
     *             property="enable",
     *             type="boolean",
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
     * @SWG\Tag(name="Admin")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function enableAppAction(Request $request, AppClient $appClient)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(AppClientType::class, $appClient, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.app_manager')->save($appClient);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $appClient = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($appClient, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }


    /**
     * @SWG\Response(
     *     response=200,
     *     description="Enable an application"
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
     * )
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="enable",
     *             type="boolean",
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
     * @SWG\Tag(name="Admin")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function disableAppAction(Request $request, AppClient $appClient)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(AppClientType::class, $appClient, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.app_manager')->save($appClient);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $appClient = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $context = new Context();
        $groups = ['app'];
        $context->setGroups($groups);
        $view = $this->view($appClient, $responseCode);
        $view->setContext($context);

        return $this->handleView($view);
    }
}