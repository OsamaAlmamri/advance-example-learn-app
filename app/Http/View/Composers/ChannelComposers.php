<?php

namespace App\Http\View\Composers;

use App\Models\Chanal;
use Illuminate\View\View;

class ChannelComposers
{

    public function compose (View $view)
    {
        $view->with("channels",  Chanal::orderBy('created_at')->get());
    }
}
