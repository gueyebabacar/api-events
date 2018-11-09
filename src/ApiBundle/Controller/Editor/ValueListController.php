<?php

namespace ApiBundle\Controller\Editor;

use ApiBundle\Form\ValueListParametersType;
use ApiBundle\Form\ValueListType;
use BusinessBundle\Entity\ValueList;
use BusinessBundle\ValueObject\ValueListParameters;
use Ee\EeCommonBundle\Exception\BusinessException;
use Ee\EeCommonBundle\Service\Validation\Form\FormBusinessException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Context\Context;


class ValueListController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of value list",
     *     @SWG\Items(ref=@Model(type=ValueList::class, groups={"event"}))
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
     * @Rest\QueryParam(name="domain", strict=false,  nullable=true)
     * @Rest\QueryParam(name="limit", strict=false,  nullable=true)
     * @Rest\QueryParam(name="offset", strict=false,  nullable=true)
     * @SWG\Tag(name="Editor")
     * @param ParamFetcher $paramFetcher
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function listAction(Request $request, ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $context = new Context();
        $groups = ['event','request_register'];
        $context->setGroups($groups);
        try {
            $paginator  = $this->get('knp_paginator');
            $defaultLimit = $this->get('api.elastic.valueList_manager')->getDefaultLimit();
            $defaultOffset = $this->get('api.elastic.valueList_manager')->getDefaultOffset();
            $limit = (empty($paramFetcher->get('limit'))) ? $defaultLimit : $paramFetcher->get('limit');
            $offset = (empty($paramFetcher->get('offset'))) ? $defaultOffset : $paramFetcher->get('offset');
            $valueListParameters =  new ValueListParameters();
            $form = $this->createForm(ValueListParametersType::class, $valueListParameters, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $filterParams = $valueListParameters->toArray();
            if ($this->get('api.elastic_process')->ping()){
                $query = $this->get('api.elastic.valueList_manager')->searchByElastic($filterParams);
            }else{
                $query = $this->get('api.doctrine.valueList_manager')->getValueLists($filterParams);
            }
            $pagination = $paginator->paginate(
                $query,
                (int)($offset / $limit) + 1,
                $limit
            );

            $valueLists = $pagination->getItems();

            $response =[
                "totalItems" => $pagination->getTotalItemCount(),
                "items" => $valueLists
            ];

            $view = $this->view($response, $responseCode);
            $view->setContext($context);

            return $this->handleView($view);
        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $valueLists = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($valueLists, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Create a value list"
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
     *             property="domain",
     *             type="string",
     *         ),
     *         @SWG\Property(
     *             property="value",
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
    public function createAction(Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $valueList = new ValueList();
        try {
            $form = $this->createForm(ValueListType::class, $valueList, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.doctrine.valueList_manager')->save($valueList);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $valueList = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($valueList, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Update a value list"
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
     *             property="domain",
     *             type="string",
     *         ),
     *         @SWG\Property(
     *             property="value",
     *             type="string",
     *         ),
     *         @SWG\Property(
     *             property="enable",
     *             type="boolean",
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
     * @ParamConverter("valueList", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function updateAction(Request $request, ValueList $valueList = null)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');

        if (empty($valueList)){
            throw new HttpException(Response::HTTP_NOT_FOUND,'Resource not found');
        }
        try {
            $form = $this->createForm(ValueListType::class, $valueList, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.doctrine.valueList_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list update', ['Domain' => $valueList->getDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $valueList = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($valueList, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Enable a value list"
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
     *     description="Technical error"
     * ),
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="enable",
     *             type="boolean"
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
     * @ParamConverter("valueList", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function enableAction(Request $request, ValueList $valueList = null)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');

        if (empty($valueList)){
            throw new HttpException(Response::HTTP_NOT_FOUND,'Resource not found');
        }
        try {
            $form = $this->createForm(ValueListType::class, $valueList, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.doctrine.valueList_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list enable', ['Domain' => $valueList->getDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $valueList = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($valueList, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Disable a value list"
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
     *     description="Technical error"
     * ),
     * @SWG\Parameter(
     *     name="body",
     *     description="....",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="enable",
     *             type="boolean",
     *             example="false"
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
     * @ParamConverter("valueList", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function disableAction(Request $request, ValueList $valueList = null)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');

        if (empty($valueList)){
            throw new HttpException(Response::HTTP_NOT_FOUND,'Resource not found');
        }
        try {
            $form = $this->createForm(ValueListType::class, $valueList, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.doctrine.valueList_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list disable', ['Domain' => $valueList->getDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $valueList = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($valueList, $responseCode);
    }
}