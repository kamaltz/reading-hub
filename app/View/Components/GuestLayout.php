<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Ubah ini untuk menunjuk ke layout baru Anda
        return view('layouts.auth-layout');
    }
}