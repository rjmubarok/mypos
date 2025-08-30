<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // public function index(){

    //    return view('backend.dashboard');
    // }
    public function index(){
//return 'hello';
         $totalcustomer = Customer::all()->count();
        $totalproduct = Product::all()->count();
        $totalcategory = Category::all()->count();
        //$todaysals=Sale::whereDate('created_at', Carbon::today())->get()->count();
        $recent_sales = Sale::orderBy('id', 'DESC')->whereDate('created_at', Carbon::today())->get();

        $todaysals = SaleItem::whereDate('created_at', Carbon::today())->sum('total');
        // return $recent_sales;
        $lastmonth = SaleItem::query()->whereBetween('created_at', [now(), now()->subMonth()])->sum('total');
        $products = Product::all();
        $sumAllProductsStock = 0;
        $sumAllProductsStockandbuyingprice = 0;
        $sumAllProductsStockandsellinggprice = 0;

        foreach ($products as $product) {

            $sumAllProductsStock += $product->stock;
            $sumAllProductsStockandbuyingprice += $product->stock * $product->purchase_price;
            $sumAllProductsStockandsellinggprice += $product->stock * $product->selling_price;
            // return $product->product_name;
        }
        //return $sumAllProductsStockandbuyingprice;



        return view('backend.dashboard', compact('totalcustomer', 'totalproduct', 'totalcategory', 'todaysals', 'lastmonth', 'recent_sales', 'sumAllProductsStockandbuyingprice', 'sumAllProductsStockandsellinggprice'));
      // return view('backend.dashboard');
    }
}
