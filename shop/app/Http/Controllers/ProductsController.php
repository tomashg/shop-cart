<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'ASC')->paginate(4);
        return view('products.index')->with('products', $products);
    }

    public function addProductToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : [];
        $cart = new Cart($oldCart);
        $cart->add($product);
        $request->session()->put('cart', $cart);
        return redirect()->route('products.index');
    }

    function getCart()
    {
        if (!Session::has('cart')) {
            return view('products.cart', ['products' => []]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('products.cart', ['products' => $cart->products, 'totalPrice' => $cart->totalPrice]);
    }

    function getOrder(Request $request)
    {
        if (!Session::has('cart')) {
            return view('products.index');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if ($cart->checkProductsAvailabilityInCart()) {
            $this->finalizeOrder($cart, $request);
        } else {
            return view('products.cart')->with(['products' => [], 'error' => 'Sorry. Selected products not available']);
        }
    }

    private function finalizeOrder($cart, $clientData)
    {
        foreach ($cart->products as $id => $product) {
            $this->reduceProductInStock($id, $product['quantity']);
        }
        $this->sendEmailToClient($cart, $clientData);
    }

    private function reduceProductInStock($id, $quantity)
    {
        $product = Product::findOrFail($id);
        $newQuantity = $product->quantity - $quantity;
        Product::where('id', $id)->update(['quantity' => $newQuantity]);
    }

    private function sendEmailToClient($cart, $clientData)
    {
        dd('email send');
    }

    function deleteFromCart($id)
    {
        if (!Session::has('cart')) {
            return view('products.index');
        }
        $cart = Session::get('cart');
        if (!empty($cart->products[$id])) {
            $price = $cart->products[$id]['price'];
            $quantity = $cart->products[$id]['quantity'];
            unset($cart->products[$id]);
            $cart->totalQuantity -= $quantity;
            $cart->totalPrice -= $price;
            Session::put('cart', $cart);
        }
        //return redirect('products')->with('success', 'updated');
        return redirect('products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
