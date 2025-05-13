<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DevicePermission extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Device Permission';
    public $permissions = 'loading';

    #[On('set_permissions')]
    public function set_permissions($data)
    {
        $data = $data['data'];
        $this->permissions = $data;
    }
    public function render()
    {
        return view('livewire.auth.settings.device-permission')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
}
