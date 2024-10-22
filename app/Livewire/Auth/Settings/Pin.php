<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Livewire\Component;

class Pin extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - PIN';
    public $pin;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/settings/pin')->data;
        $this->pin = $data->pin;
        $this->original = $data;
    }

    public function render()
    {
        return view('livewire.auth.settings.pin');
    }
    public function change_pin()
    {
        $response = $this->API_post('view/settings/pin/change', [
            'pin' => $this->pin,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->dispatch('notify', type: 'success', message: 'Perubahan berhasil disimpan');
        $this->refresh();
    }
}
