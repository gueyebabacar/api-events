<?php

namespace ApiBundle\Controller\Pub;

use Ee\EeCommonBundle\Exception\BusinessException;
use Ee\EeCommonBundle\Service\Validation\Form\FormBusinessException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Context\Context;
use BusinessBundle\ValueObject\ValueListParameters;
use ApiBundle\Form\ValueListParametersType;


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
     * @SWG\Tag(name="Public")
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
}