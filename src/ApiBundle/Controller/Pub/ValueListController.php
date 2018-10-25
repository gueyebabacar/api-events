<?php

namespace ApiBundle\Controller\Pub;

use ApiBundle\Form\ValueListType;
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
     * @SWG\Tag(name="Public")
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

}