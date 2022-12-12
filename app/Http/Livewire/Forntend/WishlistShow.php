<?php

namespace App\Http\Livewire\Forntend;

use Livewire\Component;
use App\Models\Wishlist;

class WishlistShow extends Component
{

    public function removeWishlist($wishlistID)
    {
        Wishlist::where('user_id',auth()->user()->id)->where('id',$wishlistID)->delete();
        $this->emit('wishlistAddedUpdated');
        $this->dispatchBrowserEvent('message',[
            'text' =>'wishlist item remove successfully',
            'type' => 'success',
            'status'=> 200
        ]);
    }


    public function render()
    {
        $wishlist = Wishlist::where('user_id',auth()->user()->id)->get();

        return view('livewire.forntend.wishlist-show',[

            'wishlist' => $wishlist
        ]);
    }
}
