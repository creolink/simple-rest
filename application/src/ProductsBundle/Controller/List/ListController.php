<?php

namespace ProductsBundle\Controller\Tree;

use ProductsBundle\DataObject\ListDto;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class ListController extends FOSRestController
{
    /**
     * @Get("/api/list")
     *
     * @SWG\Tag(name="List controller")
     * @SWG\Response(
     *  response=200, description="Returns list of all products",
     *  @Model(type=ListDto::class)
     * )
     * @SWG\Response(
     *  response=500, description="Returned when any internal server error occurs"
     * )
     *
     * @return ListDto
     */
    public function getTreeAction(): ListDto
    {

    }
}
