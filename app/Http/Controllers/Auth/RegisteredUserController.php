<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:empleados'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:255'],
            'apellidos' => ['required', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
            'codpostal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        // Encripto la contraseña para poder utilizar el login de Breeze
        $datos['password'] = Hash::make($request->password);
        // Añado el tipo usuario, será empleado cuando el admin le de el alta
        $datos['tipo'] = 'usuario';
        $user = User::create($datos);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
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
            'nombre' => ['required', 'max:255', 'string'],
            'cif' => ['required', 'max:255', 'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', 'unique:empresas'],
            'correo' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
            'telefono_empresa' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion_empresa' => ['nullable', 'max:255', 'string'],
            'codigo_postal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        // Cambio el nombre de las claves 'telefono_empresa' y 'direccion_empresa'
        $datosEmpresa['telefono'] = $datosEmpresa['telefono_empresa'];
        unset($datosEmpresa['telefono_empresa']);
        $datosEmpresa['direccion'] = $datosEmpresa['direccion_empresa'];
        unset($datosEmpresa['direccion_empresa']);

        $empresa = Empresa::create($datosEmpresa);

        // Validación y creación del administrador
        $datosAdmin = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:empleados'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:255'],
            'apellidos' => ['required', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
            'codpostal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        // Encripto la contraseña para poder utilizar el login de Breeze
        $datosAdmin['password'] = Hash::make($request->password);
        // Añado el tipo admin
        $datosAdmin['tipo'] = 'admin';
        // Asigno la empresa creada al admin
        $datosAdmin['empresas_id'] = $empresa->id;
        // Asigno la fecha de alta al admin
        $datosAdmin['fecha_alta'] = Carbon::now()->toDateString();

        // Ejecuto el procedimiento almacenado
        DB::select('CALL insertarAdmin(:name, :email, :password, :apellidos, :telefono, :direccion, :codpostal, :tipo, :fecha_alta, :empresas_id)', $datosAdmin);
        // Obtengo el parámetro de salida
        $empleadoId = User::max('id');
        // Obtengo el administrador
        $user = User::find($empleadoId);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
