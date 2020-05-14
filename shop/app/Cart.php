<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Cart extends Model
{
    public $products = [];
    public $totalQuantity = 0;
    public $totalPrice = 0;
    /**
     * @var mixed
     */
    private $Product;

    function __construct($oldCart)
    {
        if ($oldCart) {
            $this->products = $oldCart->products;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    function add($product)
    {
        $data = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ];
        if ($this->products && array_key_exists($product->id, $this->products)) {
            $data = $this->products[$product->id];
            $data['quantity']++;
            $data['price'] += $product->price;
        }
        $this->products[$product->id] = $data;
        $this->totalQuantity++;
        $this->totalPrice += $product->price;
    }

    function checkProductsAvailabilityInCart()
    {
        foreach ($this->products as $id => $product) {
            $productAvailability = Product::findOrFail($id);
            if ($productAvailability->quantity < $product['quantity']) {
                return false;
            }
        }
        return true;
    }
}
