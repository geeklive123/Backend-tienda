<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\OrdenProducto;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
    
     
        if ($user->admin) {
   
            $pedidos = Pedido::with('user', 'productos')->orderBy('created_at', 'desc')->get();
        } else {
    
            $pedidos = Pedido::with('productos')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    
        return new PedidoCollection($pedidos);
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
     
        $pedido = new Pedido;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

   
        $id = $pedido->id;

   
        $productos = $request->productos;

      
        $pedido_producto = [];

        foreach($productos as $producto) {
            $pedido_producto[] = [
                'pedido_id' => $id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon:: now()
            ];
        }

      
        PedidoProducto::insert($pedido_producto);
        
        return [
            'message' => 'Pedido realizado correctamente, estará listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
        $pedido->estado = 1;
        $pedido->save();

        return response()->json([
            'pedido' => $pedido
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
  
public function destroy(Pedido $pedido)
{
   
    if ($pedido->estado == 0) {
        
        PedidoProducto::where('pedido_id', $pedido->id)->delete();
        
       
        $pedido->delete();
        
        return response()->json([
            'message' => 'Pedido cancelado y eliminado con éxito',
        ]);
    } 
}

}
