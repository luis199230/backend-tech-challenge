<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /**
     * Create the basket
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        session(['basket' => $request->only('user') + [
            'created_at' => now()->format('Y-m-d H:i:s')
        ]]);
        return $this->responseSuccess('basket created with success', session()->get('basket'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        session()->forget('basket');
        return $this->responseSuccess('basket destroyed with success', session()->get('basket'));
    }

    /**
     * Add product to the basket
     * @param $user
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update($user, Request $request)
    {
        $basket = session()->get('basket');
        throw_if($basket['user'] != $user, new \Exception('not found basket'));
        $product = [
            'sku' => $request->get('sku'),
            'quantity' => (int) $request->get('quantity', 1),
            'price' => $request->get('price')
        ];
        if(empty($basket['products'])){
            session()->push('basket.products', $product);
        }else{
            $products = collect($basket['products']);
            $found = $products->firstWhere('sku',$request->get('sku'));
            if(is_null($found)){
                $products->push($product);
            }else{
                $found['quantity'] = $request->get('quantity',1);
                $products->transform(function ($item, $key) use ($found) {
                    if($item['sku'] == $found['sku']){
                        $item = $found;
                    }
                    return $item;
                });
            }
            session()->put('basket.products', $products->all());
        }
        return $this->responseSuccess('product added with success', session()->get('basket'));
    }

    public function index()
    {
        $basket = session()->get('basket');
        $total = 0;
        collect($basket['products'])->each(function ($product) use (&$total){
            $total += (double) $product['price'] * $product['quantity'];
        });
        return $this->responseSuccess('total amount in the basket', ['total' =>$total, 'basket'=>$basket]);
    }
}
