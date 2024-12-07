<?php

	use Gac\Routing\Request;
	use Gac\Routing\Response;

  require_once('App/models/product.model.php');

class ProductController {
  private $productModel;
  
  public function __construct() { 
    $this->productModel = new ProductModel();
  }

  public function getAll(Request $request): void {
    $getAllProducts = $this->productModel->getAll();
    Response::
    withHeader("Access-Control-Allow-Origin", "http://localhost:3000")::
    withHeader("Content-Type", "application/json")::
    withStatus(200, 'Success')::
    withBody($getAllProducts)::
    send();
  }

  public function getById(Request $request, int $id): void {
    $getById = $this->productModel->getById($id);
    Response::
    withHeader("Access-Control-Allow-Origin", "http://localhost:3000")::
    withHeader("Content-Type", "application/json")::
    withStatus(200, 'Success')::
    withBody($getById)::
    send();
  }

}