<?php

	use Gac\Routing\Request;
	use Gac\Routing\Response;

  require_once('App/models/admin-user.model.php');

class AdminUserController {
  private $adminUserModel;
  
  public function __construct() { 
    $this->adminUserModel = new AdminUserModel();
  }

  public function login(Request $request): void {
    $data = $request->getAllData();
    $adminLogin = $this->adminUserModel->login($data['email'], $data['password']);
    if($adminLogin){
      $res = [
        'type' => 'success',
        'message' => 'Admin Successfully Logged',
        'token' => ''
      ];
    } else {
      $res = [
        'type' => 'fail',
        'message' => 'Invalid Username or Password',
      ];
    }
    Response::withStatus(200, 'Success')::withBody($res)::send();
  }

  public function signUp(Request $request): void {
    // $adminLogin = $this->adminUserModel->login();
    Response::
    withHeader("Access-Control-Allow-Origin", "http://localhost:3000")::
    withHeader("Content-Type", "application/json")::
    withStatus(200, 'Success')::
    withBody($request)::
    send();
  }

}