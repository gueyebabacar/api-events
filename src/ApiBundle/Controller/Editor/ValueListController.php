<?php

namespace ApiBundle\Controller\Editor;

use ApiBundle\Form\ValueListType;
use BusinessBundle\Entity\Tag;
use BusinessBundle\Entity\ValueList;
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
    public function listAction(ParamFetcher $paramFetcher)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $data = $this->get('api.value_list_manager')->getValueLists($paramFetcher);

        } catch(BusinessException $ex) {
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
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
            $this->get('api.tag_manager')->save($valueList);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
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
    public function updateAction(Request $request, ValueList $valueList)
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
            $this->get('api.tag_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list update', ['Domain' => $valueList->setDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
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
    public function enableAction(Request $request, ValueList $valueList)
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
            $this->get('api.tag_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list enable', ['Domain' => $valueList->setDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
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
    public function disableAction(Request $request, ValueList $valueList)
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
            $this->get('api.tag_manager')->save($valueList);
            $this->get('app_logger')->logInfo('Value list disable', ['Domain' => $valueList->setDomain(), 'Value' => $valueList->getValue(), 'Key' => $valueList->getKey()]);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $valueList = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($valueList, $responseCode);
    }
}