<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function getAllProducts()
    {
        $allProducts = Product::paginate(perPage: 15);

        if(!$allProducts){
            return response([
                'message' => 'There are no available products'
            ], 404);
        }

        return response([
            'data' => $allProducts,
            'message' => 'You have successfully fetched all available products'
        ], 200);
    }
}
