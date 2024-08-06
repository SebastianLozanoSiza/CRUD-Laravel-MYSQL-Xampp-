<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrudController extends Controller
{
    public function index(){
        $datos = DB::select("SELECT * FROM producto");
        return view("welcome")->with("datos", $datos);
    }

    public function create(Request $request){
        try{
            $sql = DB::insert("INSERT INTO producto(id_producto, nombre, precio, cantidad) VALUES (?,?,?,?) ", [
                $request->txtcodigo,
                $request->txtnombre,
                $request->txtprecio,
                $request->txtcantidad
            ]);
        }catch (\Throwable $th){
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("Correcto", "Producto registrado correctamente");
        } else {
            return back()->with("Incorrecto", "Error al registrar");
        }
    }

    public function update(Request $request){
        try {
            $sql = DB::update("UPDATE producto set nombre =?, precio=?, cantidad=? WHERE id_producto = ?", [
                $request->txtnombre,
                $request->txtprecio,
                $request->txtcantidad,
                $request->txtcodigo
            ]);
            if($sql == 0){
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("Correcto", "Producto modificado correctamente");
        } else {
            return back()->with("Incorrecto", "Error al modificar");
        }
    }

    public function delete($id){
        try {
            $sql = DB::delete("DELETE FROM producto WHERE id_producto =$id");
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("Correcto", "Producto eliminado correctamente");
        } else {
            return back()->with("Incorrecto", "Error al eliminar");
        }
    }
}
