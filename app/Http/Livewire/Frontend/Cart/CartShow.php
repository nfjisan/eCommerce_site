<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $totalPrice = 0;

    public function decrementQuantity($cartId)
    {
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData)
        {
            if($cartData->productColor()->where('id', $cartData->product_color_id)->exists()){
                $productColor = $cartData->productColor()->where('id', $cartData->product_color_id)->first();
                if($productColor->quantity > $cartData->quantity){
                    $cartData->decrement('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Only' .$productColor->quantity . 'Quantity Available',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }
            }else{
                if($cartData->product->quantity > $cartData->quantity){

                    $cartData->decrement('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Only' .$cartData->product->quantity . 'Quantity Available',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }

            }


        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'something with wrong',
                'type' => 'error',
                'status' =>  404
            ]);
        }
    }

    public function incrementQuantity($cartId)
    {
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData)
        {
            if($cartData->productColor()->where('id', $cartData->product_color_id)->exists()){
                $productColor = $cartData->productColor()->where('id', $cartData->product_color_id)->first();
                if($productColor->quantity > $cartData->quantity){
                    $cartData->increment('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Only' .$productColor->quantity . 'Quantity Available',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }
            }else{
                if($cartData->product->quantity > $cartData->quantity){

                    $cartData->increment('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Only' .$cartData->product->quantity . 'Quantity Available',
                        'type' => 'success',
                        'status' =>  200
                    ]);
                }

            }


        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'something with wrong',
                'type' => 'error',
                'status' =>  404
            ]);
        }
    }


    public function removeCartItem($cartId)
    {
        $cartRemoveData = Cart::where('user_id',auth()->user()->id)->where('id',$cartId)->first();
        if($cartRemoveData){
            $cartRemoveData->delete();
            $this->emit('CartAddedUpdated');

            $this->dispatchBrowserEvent('message',[
                'text' =>'Cart Item Remove Succesfully',
                'type' => 'success',
                'status'=> 200
            ]);
        }else{
            $this->dispatchBrowserEvent('message',[
                'text' =>'uff.!! something wrong',
                'type' => 'error',
                'status'=> 500
            ]);
        }
    }


    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show',[
            'cart' => $this->cart
        ]);
    }
}
