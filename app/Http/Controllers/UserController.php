<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if (empty($users))
            return response()->json(null, 204);
        else
            return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        // Validar existencia del nombre del usero
        if ($this->validateEmail($user->email)) {
            throw new ConflictHttpException('El correo `'.$user->email.'` ya existe');
        } else if ($this->validateName($user->name)) {
            throw new ConflictHttpException('El nombre de usuario `'.$user->name.'` ya existe');
        } else {
            $user->save();
            return $user;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = new User();
        $user = $user->find($id);

        // Validar existencia por id
        if (!$user) {
            throw new ModelNotFoundException("Usuario no encontrado");
        } else
            return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Método para validar la existencia del correo electrónico
     */
    private function validateEmail($email) {
        $user = User::where('email', $email)->first();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    private function validateName($name) {
        $user = User::where('name', $name)->first();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
