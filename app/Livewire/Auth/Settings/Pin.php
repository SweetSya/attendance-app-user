<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Livewire\Component;

class Pin extends Component
{
    use HasApiHelper;

    protected $route_name = 'settings/pin';
    protected $api_url = 'view/settings/pin';

    public $title = 'Pengaturan - PIN';
    public $pin;
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
        $this->refresh(true);
    }
}
