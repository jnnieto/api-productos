<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::where('state', '=', true)->get();

        if (empty($products))
            return response()->json(null, 204);
        else
            return response()->json($products, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->state = true;

        // Validar existencia del nombre del producto
        if ($this->validateProductName($product->name)) {
            throw new ConflictHttpException('El producto `'.$product->name.'` ya existe');
        } else {
            $product->save();
            return $product;
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

        $product = new Product();
        $product = $product->find($id);

        // Validar existencia por id
        if (!$product || $product->state == false) {
            throw new ModelNotFoundException("Producto no encontrado");
        } else
            return response()->json($product, 200);

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

        $product = new Product();
        $product = $product->find($id);

        // Validar la existencia del producto por id
        if (!$product || $product->state == false) {
            throw new ModelNotFoundException("Producto no encotrado");
        }

        // Validar existencia de producto
        if ($this->validateProductName($request->name) && $product->id != $id) {
            throw new ConflictHttpException('El producto `'.$request->name.'` ya existe');
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock = $request->stock;

        $product->save();
        return $product;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = new Product();
        $product = $product->find($id);

        // Validar existencia por id
        if (!$product || $product->state == false) {
            throw new ModelNotFoundException("Producto no encontrado");
        } else {
            $product->state = false;
            $product->save();
            return response()->json(null, 204);
        }

    }

    /**
     * Método que funciona como bandera par validar la existencia de un producto por su nombre
     */
    private function validateProductName($nombre) {
        $product = Product::where('name', $nombre)->first();
        if ($product) {
            return true;
        } else {
            return false;
        }
    }

}
