<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class DeviceUuid extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Device UUID';
    public $device_uuid;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $this->device_uuid = Cookie::get(env('APP_DEVICE_UUID_COOKIES_NAME'));
    }
    public function render()
    {
        return view('livewire.auth.settings.device-uuid')->layout('components.layouts.app', [
            'title' => $this->title
    ]);;
    }
}
