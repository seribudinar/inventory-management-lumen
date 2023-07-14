<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Product',
            'data'    => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Field dibutuhkan',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $product = Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product Berhasil disimpan',
                    'data'    => $product
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product gagal disimpan'
                ], 400);
            }
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Product!',
                'data'      => $product
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {
            $product = Product::whereId($id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product Berhasil Diupdate!',
                    'data' => $product
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::whereId($id)->first();

        if ($product) {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product tidak ditemukan Gagal Dihapus!',
            ], 404);
        }
    }
}
