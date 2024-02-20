<?php

namespace App\Http\Controllers;

use App\Services\Implementation\UserServiceImplement;
use App\Validator\UserValidator;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserServiceImplement
     */
    private $userService;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var UserValidator
     */
    private $validator;


    public function __construct(UserServiceImplement $userService, Request $request, UserValidator $userValidator)
    {
        $this->userService = $userService;
        $this->request = $request;
        $this->validator = $userValidator;
    }

    function createUser()
    {
        $response = response("", 201);

        $validator = $this->validator->validate();
        if ($validator->fails()){
            $response = response([
                "status" => 422,
                "message" => "Error",
                "errors" => $validator->errors()
            ], 422);
        } else {
            $this->userService->postUser($this->request->all()); 
        }

        

        return $response;
    }

    function getListUser(){

        return response($this->userService->getUser());
    }

    function putUser(int $id){

        $response = response("", 202); // creamos la respuesta con un codigo 202

        $validator = $this->validator->validate();
        if ($validator->fails()){
            $response = response([
                "status" => 422,
                "message" => "Error",
                "errors" => $validator->errors()
            ], 422);
        } else {
            $this->userService->putUser($this->request->all(), $id); //llamaos al servicio para que busque el id
        }
        

        return $response; // retormanos la respuesta
    }

    function delUser(int $id){

        $this->userService->delUser($id);
        return response("", 204);
    }

    function restoreUser(int $id){

        $this->userService->restoreUser($id);
        return response("", 204);
    }
}
