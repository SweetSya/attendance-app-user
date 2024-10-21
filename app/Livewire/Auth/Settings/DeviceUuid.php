<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
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
        $data = $this->API_getJSON('view/settings/device-uuid');
        $this->device_uuid = $data->device_uuid;
        $this->original = $data;
    }
    public function render()
    {
        return view('livewire.auth.settings.device-uuid', [
            'title' => $this->title
        ]);
    }
}
