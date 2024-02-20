<?php

namespace App\Services\Implementation;


use App\Services\Interfaces\IUserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServiceImplement implements IUserServiceInterface
{
    private $model;

    function __construct()
    {
        $this->model = new User();
    }

    function getUser(){

        return $this->model->withTrashed()->get(); // con el withTrashed() nos traemos los eliminadostambien

    }

    function getUserById(int $id){

    }

    /**
     * crea un usuario en el sistema
     */
    function postUser(array $user)
    {
        $user['password'] = Hash::make($user['password']);
        $this->model->create($user);
    }
    
    function putUser(array $user, int $id)
    {
        // 1ro lo buscamos, nos traemos el 1ro, reyenamos con el user que nos dan y grabamos
        $user['password'] = Hash::make($user['password']); //por si nos mandan la password
        $this->model->where('id', $id)
        ->first()
        ->fill($user)
        ->save();
    }

    function delUser(int $id)
    {
        $user = $this->model->find($id); 

        if ( $user != null)
        {
            $user->delete();
        }

    }

    function restoreUser(int $id)
    {
        $user = $this->model->withTrashed()->find($id); 

        if ( $user != null)
        {
            $user->restore();
        }

    }
    
}