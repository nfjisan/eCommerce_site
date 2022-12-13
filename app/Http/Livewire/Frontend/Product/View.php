<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $productColorSelectedQuantity, $quantityCount=1, $productColorId;

    public function addWishList($productId)
    {
        if(Auth::check())
        {
            if(Wishlist::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists())
            {
                session()->flash('message','already added to wishlist');
                $this->dispatchBrowserEvent('message',[
                    'text' =>'already added to wishlist',
                    'type' => 'warning',
                    'status'=> 409
                ]);
                return false;
            }else{
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId,

                ]);
                $this->emit('wishlistAddedUpdated');
                session()->flash('message','wishlist added succesfully');
                $this->dispatchBrowserEvent('message',[
                    'text' =>'wishlist added succesfully',
                    'type' => 'success',
                    'status'=> 200
                ]);
            }

        }else{
            session()->flash('message','please login first');

            $this->dispatchBrowserEvent('message',[
                'text' =>'please login first',
                'type' => 'info',
                'status'=> 401
            ]);
            return false;
        }
    }

    public function colorSelected($productColorId)
    {
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->productColorSelectedQuantity = $productColor->quantity;

        if($this->productColorSelectedQuantity == 0){
            $this->productColorSelectedQuantity = 'outOfStock';
        }
    }


    public function decrementQuantity()
    {
        if($this->quantityCount > 1){
            $this->quantityCount--;
        }

    }

    public function incrementQuantity()
    {
        if($this->quantityCount < 10){
            $this->quantityCount++;
        }

    }


    public function addToCart($productId)
    {
        if(Auth::check()){
            if($this->product->where('id', $productId)->where('status','0')->exists()){
                if($this->product->productColors()->count() > 1){
                    if($this->productColorSelectedQuantity != NULL){
                        if(Cart::where('user_id',auth()->user()->id)
                        ->where('product_id', $productId)
                        ->where('product_color_id', $this->productColorId)
                        ->exists()){
                            $this->dispatchBrowserEvent('message',[
                                'text' =>'  product already added',
                                'type' => 'warning',
                                'status'=> 200
                            ]);
                        }else{
                            $productColor = $this->product->productColors()->where('id',$this->productColorId)->first();
                        if($productColor->quantity > 0){
                            if($productColor->quantity > $this->quantityCount){

                                Cart::create([

                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'product_color_id' => $this->productColorId,
                                    'quantity' => $this->quantityCount
                                ]);

                                $this->dispatchBrowserEvent('message',[
                                    'text' =>'product added to cart',
                                    'type' => 'success',
                                    'status'=> 200
                                ]);
                            }else{
                                $this->dispatchBrowserEvent('message',[
                                    'text' =>'Only'.$this->product->quantity.'Quantity Available',
                                    'type' => 'warning',
                                    'status'=> 404
                                ]);
                            }
                        }else{
                            $this->dispatchBrowserEvent('message',[
                                'text' =>'Out of Stock',
                                'type' => 'warning',
                                'status'=> 404
                            ]);
                        }
                        }


                    }else{
                        $this->dispatchBrowserEvent('message',[
                            'text' =>'Select Your product color',
                            'type' => 'info',
                            'status'=> 404
                        ]);
                    }
                }else{
                    if(Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists()){
                        $this->dispatchBrowserEvent('message',[
                            'text' =>'Product Already Added',
                            'type' => 'warning',
                            'status'=> 200
                        ]);
                    }else{
                        if($this->product->quantity > 0){
                            if($this->product->quantity > $this->quantityCount){

                                Cart::create([

                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);

                                $this->dispatchBrowserEvent('message',[
                                    'text' =>'product added to cart',
                                    'type' => 'success',
                                    'status'=> 200
                                ]);

                            }else{
                                $this->dispatchBrowserEvent('message',[
                                    'text' =>'Only'.$this->product->quantity.'Quantity Available',
                                    'type' => 'warning',
                                    'status'=> 404
                                ]);
                            }
                        }else{
                            $this->dispatchBrowserEvent('message',[
                                'text' =>'Out of Stock',
                                'type' => 'warning',
                                'status'=> 404
                            ]);
                        }
                    }

                }

            }else{
                $this->dispatchBrowserEvent('message',[
                    'text' =>'Product Does not exists',
                    'type' => 'warning',
                    'status'=> 404
                ]);
            }
        }else{

            $this->dispatchBrowserEvent('message',[
                'text' =>'please login first then added cart',
                'type' => 'info',
                'status'=> 401
            ]);
        }
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }


    public function render()
    {
        return view('livewire.frontend.product.view',[
            'category' =>$this->category,
            'product' =>$this->product,
        ]);
    }
}
