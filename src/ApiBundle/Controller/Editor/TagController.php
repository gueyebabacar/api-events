<?php

namespace ApiBundle\Controller\Editor;

use ApiBundle\Form\TagType;
use BusinessBundle\Entity\Tag;
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


class TagController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return list of tags"
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
            $data = $this->get('api.tag_manager')->getTags($paramFetcher);

        } catch(BusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $data = $ex->getPayload();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->view($data, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Create a tag"
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
    public function createAction(Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        $tag = new Tag();
        try {
            $form = $this->createForm(TagType::class, $tag, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.tag_manager')->save($tag);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $tag = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($tag, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Update a tag"
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
     * @ParamConverter("tag", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function updateAction(Request $request, Tag $tag)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(TagType::class, $tag, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.tag_manager')->save($tag);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $tag = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($tag, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Enable a tag"
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
     * @ParamConverter("tag", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function enableAction(Request $request, Tag $tag)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(TagType::class, $tag, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.tag_manager')->save($tag);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $tag = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($tag, $responseCode);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Disable a tag"
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
     * @ParamConverter("tag", converter="doctrine.orm")
     * @return \FOS\RestBundle\View\View
     * @throws \Exception
     */
    public function disableAction(Request $request, Tag $tag)
    {
        $responseCode = Response::HTTP_OK;
        $logger = $this->get('ee.app.logger');
        try {
            $form = $this->createForm(TagType::class, $tag, ['method' => $request->getMethod()]);
            $form->handleRequest($request);
            $this->get('ee.form.validator')->validate($form);
            $this->get('api.tag_manager')->save($tag);

        } catch(FormBusinessException $ex) {
            foreach ($ex->getPayload() as $value){
                $logger->logInfo($value[0]->getMessage());
            }
            $logger->logError($ex->getMessage(), $ex);
            $tag = $ex->getPayload();
            $responseCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        return $this->view($tag, $responseCode);
    }
}