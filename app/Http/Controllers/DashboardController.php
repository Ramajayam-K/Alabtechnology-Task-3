<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\products;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getProduct(Request $request)
    {
        $stock = (isset($request->stock)) ? $request->stock : 10;
        $getProductData = products::where('stock', '>', $stock)->get();
        $content = '<table class="table table-hover table-bordered" id="QueryListOutput">
            <thead>
                <tr>
                    <td>S.no</td>
                    <td>name</td>
                    <td>description</td>
                    <td>price</td>
                    <td>stock</td>
                </tr>
            </thead>
            <tboby>
            ';

        foreach ($getProductData as $key => $value) {
            $content .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value->name . '</td>
                    <td>' . $value->description . '</td>
                    <td>' . $value->price . '</td>
                     <td>' . $value->stock . '</td>
                </tr>';
        }

        $content .= '</tboby>
        </table>';

        return response()->json([$content]);
    }

    public function getOrderData(Request $request)
    {
        $user_id = (isset($request->user_id)) ? $request->user_id : 1;
        $getOrderData = orders::with('user')->where('user_id', '=', $user_id)->get();
        $content = '<table class="table table-hover table-bordered" id="QueryListOutput">
        <thead>
            <tr>
                <th>S.No</th>
                <th>User Name</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($getOrderData as $key => $value) {
            $content .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value->user->name . '</td>
                    <td>' . $value->total_price . '</td>
                    <td>' . $value->status . '</td>
                </tr>';
        }
        $content .= '</tbody></table>';

        return response()->json([$content]);
    }

    public function UpdateProductStock(Request $request)
    {
        $orderId = (isset($request->orderId)) ? $request->orderId : 1;
        $order = orders::with('items.product')->findOrFail($orderId);
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->stock = ($product->stock<=0)?0:$product->stock;
            $product->save();
        }
        
        $getProductData = products::all();
        $content = '<table class="table table-hover table-bordereded" id="QueryListOutput">
            <thead>
                <tr>
                    <td>S.no</td>
                    <td>name</td>
                    <td>description</td>
                    <td>price</td>
                    <td>stock</td>
                </tr>
            </thead>
            <tboby>
            ';

        foreach ($getProductData as $key => $value) {
            $content .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value->name . '</td>
                    <td>' . $value->description . '</td>
                    <td>' . $value->price . '</td>
                     <td>' . $value->stock . '</td>
                </tr>';
        }

        $content .= '</tboby>
        </table>';

        return response()->json([$content]);
    }
}
