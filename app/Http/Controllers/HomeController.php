<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Designacione;
use App\Models\Marcacione;
use App\Models\Usercliente;
use App\Models\Vwdesignacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!hayRevisionHoy()) {
            procesosDiarios();
        }
        if (Auth::user()->template == "OPER") {
            $empleado_id = Auth::user()->empleados[0]->id;
            $designaciones = null;
            if ($empleado_id) {
                $designaciones = Designacione::where('fechaFin', '>=', date('Y-m-d'))
                    ->where('fechaInicio', '<=', date('Y-m-d'))
                    ->where('empleado_id', $empleado_id)
                    ->where('estado', 1)
                    ->orderBy('id', 'DESC')->first();
            }
            
            if ($designaciones) {
                Session::put('designacion-oper', $designaciones->id);
                if ($designaciones->turno) {
                    Session::put('cliente_id-oper', $designaciones->turno->cliente_id);
                }
               
                
            }

            return view('operativo', compact('designaciones'));
        }
        if (Auth::user()->template == "ADMIN") {

            return view('admin.home');
        }
        

        if (Auth::user()->template == "CLIENTE") {
            $usuariocliente = Usercliente::where('user_id', Auth::user()->id)->first();
            $cliente = $usuariocliente->cliente;
            $hoy = date('Y-m-d');
            $designaciones = Vwdesignacione::where([
                ['cliente_id', $cliente->id],
                ['fechaInicio', '<=', $hoy],
                ['fechaFin', '>=', $hoy],
                ['estado', true],
            ])->get();
            Session::put('cliente_id-oper', $cliente->id);
            return view('customer.home', compact('cliente', 'designaciones'));
        }
    }
}
