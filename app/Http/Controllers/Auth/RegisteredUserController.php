<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'max:255', 'alpha'],
            'email' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:empleados'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:255'],
            'apellidos' => ['required', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
        ]);
        // Encripto la contraseña para poder utilizar el login de Breeze
        $datos['password'] = Hash::make($request->password);
        // Añado el tipo empleado
        $datos['tipo'] = 'empleado';
        $user = User::create($datos);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the registration view for the company.
     *
     * @return \Illuminate\View\View
     */
    public function createCompany()
    {
        return view('auth.register-company');
    }

    /**
     * Handle an incoming company registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeCompany(Request $request)
    {
        // Validación y creación de la empresa 
        $datosEmpresa = $request->validate([
            'nombre' => ['required', 'max:255', 'alpha_num'],
            'cif' => ['required', 'max:255', 'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', 'unique:empresas'],
            'correo' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
            'telefono_empresa' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion_empresa' => ['nullable', 'max:255', 'string'],
        ]);
        // Cambio el nombre de las claves 'telefono_empresa' y 'direccion_empresa'
        $datosEmpresa['telefono'] = $datosEmpresa['telefono_empresa'];
        unset($datosEmpresa['telefono_empresa']);
        $datosEmpresa['direccion'] = $datosEmpresa['direccion_empresa'];
        unset($datosEmpresa['direccion_empresa']);

        $empresa = Empresa::create($datosEmpresa);

        // Validación y creación del administrador
        $datosAdmin = $request->validate([
            'name' => ['required', 'max:255', 'alpha'],
            'email' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:empleados'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:255'],
            'apellidos' => ['required', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
        ]);
        // Encripto la contraseña para poder utilizar el login de Breeze
        $datosAdmin['password'] = Hash::make($request->password);
        // Añado el tipo admin
        $datosAdmin['tipo'] = 'admin';
        // Asigno la empresa creada al admin
        $datosAdmin['empresas_id'] = $empresa->id;

        $user = User::create($datosAdmin);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
