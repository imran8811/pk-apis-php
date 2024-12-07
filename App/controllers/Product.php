<?php

	use Gac\Routing\Request;
	use Gac\Routing\Response;

  require_once('App/models/product.model.php');

class ProductController {
  private $productModel;
  
  public function __construct() { 
    $this->productModel = new ProductModel();
  }

  public function addProduct(Request $request): void {
    $data = $request->getAllData();
    $addProduct = $this->productModel->addProduct($data);
    if($addProduct){
      $res = [
        'type' => 'success',
        'p_id' => $addProduct,
        'message' => 'Product Added Successfully'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to add product'
      ];
    }
    Response::withStatus(200, 'Success')::withBody($res)::send();
  }

  public function updateProduct(Request $request, int $id): void {
    $data = $request->getAllData();
    $updateProduct = $this->productModel->updateProduct($data, $id);
    if($updateProduct){
      $res = [
        'type' => 'success',
        'message' => 'Product Updated Successfully',
        'data' => $updateProduct
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to update product'
      ];
    }
    Response::withStatus(200, 'Success')::withBody($res)::send();
  }

  public function updateImagePath(Request $request): void {
    $data = $request->getAllData();
    $updateImagePath = $this->productModel->updateImagePath($data);
    if($updateImagePath){
      $res = [
        'type' => 'success',
        'message' => 'Image Uploaded Successfully'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to upload image'
      ];
    }
    Response::withStatus(200, 'Success')::withBody($res)::send();
  }

  public function getAll(Request $request): void {
    $getAllProducts = $this->productModel->getAll();
    if($getAllProducts){
      Response::withStatus(200, 'Success')::withBody($getAllProducts)::send();
    } else {
      Response::withStatus(200, 'Success')::withBody([])::send();
    }
  }

  public function getById(Request $request, int $id): void {
    $getById = $this->productModel->getById($id);
    Response::withStatus(200, 'Success')::withBody([$getById])::send();
  }

  public function getByDept(Request $request, string $dept): void {
    $getBydept = $this->productModel->getBydept($dept);
    Response::withStatus(200, 'Success')::withBody($getBydept)::send();
  }

  public function getLatestArticleNo(): void {
    $getLatestArticleNo = $this->productModel->getLatestArticleNo();
    Response::withStatus(200, 'Success')::withBody($getLatestArticleNo)::send();
  }

  public function deleteById(Request $request, int $id): void {
    $deleteById = $this->productModel->deleteById($id);
    if($deleteById){
      $res = [
        'type' => 'success',
        'message' => 'Product Updated Successfully',
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to update product'
      ];
    }
    Response::withStatus(200, 'Success')::withBody($res)::send();
  }

}