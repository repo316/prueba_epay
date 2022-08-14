<?php

namespace App\Http\Controllers;


use App\Libs\HttpSoap;
use App\Libs\RequestValidate;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class ApiController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    use HttpResponseTrait;

    public function RegistroCliente(Request $request){
        $validate=new RequestValidate($request, [
            'Documento'=>[
                'required'
            ],
            'Nombres'=>[
                'required',
                'min:2'
            ],
            'Email'=>[
                'required',
                'email'
            ],
            'Celular'=>[
                'required',
                'numeric',
                'min:5'
            ]
        ]);

        if($validate->isValid()){
            $data=[
                'Documento'=>$request->get('Documento'),
                'Nombres'=>$request->get('Nombres'),
                'Email'=>$request->get('Email'),
                'Celular'=>$request->get('Celular'),
            ];
            $body=view('soap.registro_cliente', ['data'=>$data])->render();
            $res = HttpSoap::send('http://prueba_gpay.test/api/registro/cliente',$body);
            if($res['cod_error']=='01'){
                $result=$this->success($res['data']);
            }
            else{
                $result=$this->error('04', $res['message_error']);
            }
        }
        else{
            $result=$this->error('02', $validate->failMessages());
        }

        if($validate->getRequestType()=='json'){
            return response()->json($result, 200);
        }
        else{
            return $this->soapResponse($result);
        }
    }

    public function RecargaBilletera(Request $request){
        $result=$this->defaultError();
        $validate=new RequestValidate($request, [
            'Documento'=>[
                'required',
                'min:5'
            ],
            'Celular'=>[
                'required',
                'numeric',
                'min:5'
            ],
            'Valor'=>[
                'required',
                'numeric',
                'min:5'
            ],
        ]);

        if($validate->isValid()){
            $data=[
                'Documento'=>$request->get('Documento'),
                'Nombres'=>$request->get('Nombres'),
                'Valor'=>$request->get('Valor'),
            ];
            $body=view('soap.cargar_billetera', ['data'=>$data])->render();
            $res = HttpSoap::send('http://prueba_gpay.test/api/billetera/cargar',$body);
            if($res['cod_error']=='01'){
                $result=$this->success($res['data']);
            }
            else{
                $result=$this->error('04', $res['message_error']);
            }
        }
        else{
            $result=$this->error('02', $validate->failMessages());
        }

        if($validate->getRequestType()=='json'){
            return response()->json($result, 200);
        }
        else{
            return $this->soapResponse($result);
        }
    }

    public function Pagar(Request $request){
        $result=$this->defaultError();
        $validate=new RequestValidate($request, [
            'Documento'=>[
                'required',
                'min:5'
            ],
            'Celular'=>[
                'required',
                'numeric',
                'min:5'
            ],
            'Valor'=>[
                'required',
                'numeric',
                'min:5'
            ],
            'Descripcion'=>[
                'required',
                'min:4'
            ],
        ]);

        if($validate->isValid()){
            $data=[
                'Documento'=>$request->get('Documento'),
                'Nombres'=>$request->get('Nombres'),
                'Valor'=>$request->get('Valor'),
                'Descripcion'=>$request->get('Descripcion'),
            ];
            $body=view('soap.generar_pago', ['data'=>$data])->render();
            $res = HttpSoap::send('http://prueba_gpay.test/api/billetera/generar/pago',$body);
            if($res['cod_error']=='01'){
                $result=$this->success($res['data']);
            }
            else{
                $result=$this->error('04', $res['message_error']);
            }
        }
        else{
            $result=$this->error('02', $validate->failMessages());
        }

        if($validate->getRequestType()=='json'){
            return response()->json($result, 200);
        }
        else{
            return $this->soapResponse($result);
        }
    }

    public function ConfirmarPago(Request $request, $token){
        $result=$this->defaultError();
        $validate=new RequestValidate($request, [
            'Documento'=>[
                'required',
                'min:5'
            ],
            'Celular'=>[
                'required',
                'numeric',
                'min:5'
            ],
            'Session'=>[
                'required',
                'min:5',
            ],
        ]);

        if($validate->isValid()){
            $data=[
                'Documento'=>$request->get('Documento'),
                'Nombres'=>$request->get('Nombres'),
                'Session'=>$request->get('Session'),
            ];
            $body=view('soap.confirmar_pago', ['data'=>$data])->render();
            $res = HttpSoap::send("http://prueba_gpay.test/api/billetera/confirmar/$token/pago",$body);
            if($res['cod_error']=='01'){
                $result=$this->success($res['data']);
            }
            else{
                $result=$this->error('04', $res['message_error']);
            }
        }
        else{
            $result=$this->error('02', $validate->failMessages());
        }

        if($validate->getRequestType()=='json'){
            return response()->json($result, 200);
        }
        else{
            return $this->soapResponse($result);
        }
    }

    public function ConsultarSaldo(Request $request){
        $result=$this->defaultError();
        $validate=new RequestValidate($request, [
            'Documento'=>[
                'required',
                'min:5'
            ],
            'Celular'=>[
                'required',
                'numeric',
                'min:5'
            ],
        ]);

        if($validate->isValid()){
            $data=[
                'Documento'=>$request->get('Documento'),
                'Celular'=>$request->get('Celular'),
            ];
            $body=view('soap.consultar_saldo', ['data'=>$data])->render();
            $res = HttpSoap::send("http://prueba_gpay.test/api/billetera/saldo",$body);
            if($res['cod_error']=='01'){
                $result=$this->success($res['data']);
            }
            else{
                $result=$this->error('04', $res['message_error']);
            }
        }
        else{
            $result=$this->error('02', $validate->failMessages());
        }

        if($validate->getRequestType()=='json'){
            return response()->json($result, 200);
        }
        else{
            return $this->soapResponse($result);
        }
    }
}
