<?php

require_once('database.php');

class ProductModel {
  public $pdo;

    public function __construct() {
        $this->pdo = DBConnect::getInstance();
    }      
  
  public function getAll() {
    $query = 'SELECT * FROM products LEFT JOIN images ON products.p_id=images.p_id';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();
    return $res;
  }

  public function addProduct($data) {
    $query = "INSERT INTO products 
            (article_no, price, dept, category, slug, sizes, fitting, fabric, fabric_weight, wash_type, moq, piece_weight, color) 
            VALUES 
            (:article_no, :price, :dept, :category, :slug, :sizes, :fitting, :fabric, :fabric_weight, :wash_type, :moq, :piece_weight, :color)";
    $stmt= $this->pdo->prepare($query);
    $stmt->execute($data);
    $stmt2 = $this->pdo->prepare('SELECT MAX(p_id) from products');
    $stmt2->execute();
    $res = $stmt2->fetchColumn();
    return $res;
  }

  public function updateProduct($data, $id) {
    try{
      $query = "UPDATE products SET 
            price=:price, 
            dept=:dept, 
            category=:category, 
            slug=:slug, 
            sizes=:sizes, 
            fitting=:fitting,
            fabric=:fabric,
            fabric_weight=:fabric_weight,
            wash_type=:wash_type,
            moq=:moq,
            piece_weight=:piece_weight,
            color=:color
            WHERE p_id =:id";
      $stmt= $this->pdo->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':price', $data['price'], PDO::PARAM_INT);
      $stmt->bindParam(':dept', $data['dept'], PDO::PARAM_STR);
      $stmt->bindParam(':category', $data['category'], PDO::PARAM_STR);
      $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
      $stmt->bindParam(':sizes', $data['sizes'], PDO::PARAM_STR);
      $stmt->bindParam(':fitting', $data['fitting'], PDO::PARAM_STR);
      $stmt->bindParam(':fabric', $data['fabric'], PDO::PARAM_STR);
      $stmt->bindParam(':fabric_weight', $data['fabric_weight'], PDO::PARAM_STR);
      $stmt->bindParam(':wash_type', $data['wash_type'], PDO::PARAM_STR);
      $stmt->bindParam(':moq', $data['moq'], PDO::PARAM_INT);
      $stmt->bindParam(':piece_weight', $data['piece_weight'], PDO::PARAM_INT);
      $stmt->bindParam(':color', $data['color'], PDO::PARAM_STR);
      $stmt->execute();
      $res = $stmt->rowCount();
    } catch(PDOException $e){
      return $e->getMessage();
    }
    return $res;
  }

  public function updateImagePath($data) {
    switch ($data['image_type']) {
      case 'front':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_front) 
          VALUES(:p_id, :article_no, :image_front)
          ON DUPLICATE KEY UPDATE 
          image_front = VALUES(image_front)');
        $query->bindParam(':image_front', $data['image_front'], PDO::PARAM_STR);
        break;
    case 'back':
      $query = $this->pdo->prepare(
        'INSERT INTO images (p_id, article_no, image_back) 
          VALUES(:p_id, :article_no, :image_back)
          ON DUPLICATE KEY UPDATE 
          image_back= VALUES(image_back)');
      $query->bindParam(':image_back', $data['image_back'], PDO::PARAM_STR);
      break;
      case 'side':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_side) 
            VALUES(:p_id, :article_no, :image_side)
            ON DUPLICATE KEY UPDATE 
            image_side= VALUES(image_side)');
        $query->bindParam(':image_side', $data['image_side'], PDO::PARAM_STR);
      break;
      case 'image_other_one':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_other_one) 
          VALUES(:p_id, :article_no, :image_other_one)
          ON DUPLICATE KEY UPDATE 
          image_other_one= VALUES(image_other_one)');
      $query->bindParam(':image_other_one', $data['image_other_one'], PDO::PARAM_STR);
      break;
      case 'image_other_two':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_other_two) 
            VALUES(:p_id, :article_no, :image_other_two)
            ON DUPLICATE KEY UPDATE 
            image_other_two= VALUES(image_other_two)');
        $query->bindParam(':image_other_two', $data['image_other_two'], PDO::PARAM_STR);
        break;
        default:
        //code block
      }
    $query->bindParam(':p_id', $data['p_id']);  
    $query->bindParam(':article_no', $data['article_no']);  
    $res = $query->execute();
    return $res;
  }

  public function getById($id) {
    $query = 'SELECT * FROM products INNER JOIN images ON products.p_id=images.p_id WHERE products.p_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->fetch();
    return $res;
  }

  public function getBydept($dept) {
    $query = 'SELECT * FROM products INNER JOIN images ON products.p_id=images.p_id WHERE products.dept=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function deleteById($id) {
    $query = 'DELETE FROM products WHERE p_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->rowCount();
    if($res){
      $deleteImage = $this->deleteImagesById($id);
      if($deleteImage){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
    return $res;
  }

  public function deleteImagesById($id) {
    $query = 'DELETE FROM images WHERE p_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->rowCount();
    return $res;
  }

  public function getLatestArticleNo() {
    $query = 'SELECT MAX(article_no) from products';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetch();
    return $res['MAX(article_no)']? $res['MAX(article_no)'] : '10050';
  }
}