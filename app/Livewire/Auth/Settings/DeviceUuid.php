<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class DeviceUuid extends Component
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'settings/device-uuid';
    protected $api_url = 'view/settings/device-uuid';
    public $title = 'Pengaturan - Device UUID';
    public $device_uuid, $device_uuid_by_cookie;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh(bool $refetch = false)
    {
        // If refetch is true, we will force to fetch data from API
        if ($refetch) {
            $this->setPageSessionRefresh([$this->route_name]);
        }
        $data = $this->getPageSessionData($this->route_name, $this->api_url);
        if (property_exists($data, 'error')) {
            $this->invalidateSession($data);
            return;
        }
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
            'device_uuid' => $this->device_uuid_by_cookie,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh(true);
    }
}
