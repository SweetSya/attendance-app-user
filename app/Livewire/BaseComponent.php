<?php

namespace App\Livewire;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class BaseComponent extends Component
{
    // protected $listeners = [
    //     'hard-refresh' => 'onHardRefresh',
    // ];

    // public function onHardRefresh()
    // {
    //     $refresh_pages = Session::get('refresh_pages', []);
    //     if (!in_array($this->route_name, $refresh_pages, true)) {
    //         $refresh_pages[] = $this->route_name;
    //         Session::put('refresh_pages', $refresh_pages);
    //     }
    // }
}
