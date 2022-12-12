<?php

namespace App\Http\Livewire\Frontend\Product;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $productColorSelectedQuantity, $quantityCount=1;

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
