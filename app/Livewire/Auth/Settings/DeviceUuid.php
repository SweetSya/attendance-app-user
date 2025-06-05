<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class DeviceUuid extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Device UUID';
    public $device_uuid, $device_uuid_by_cookie;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $this->device_uuid_by_cookie = Cookie::get(env('APP_DEVICE_UUID_COOKIES_NAME'));
        $data = $this->API_getJSON('view/settings/device-uuid')->data;
        $this->device_uuid = $data->device_uuid;
    }
    public function render()
    {
        return view('livewire.auth.settings.device-uuid')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function change_device_uuid()
    {
        $response = $this->API_postJSON('view/settings/device-uuid/change', [
            'device_uuid' => $this->device_uuid,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
}
