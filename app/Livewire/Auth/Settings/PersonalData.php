<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Livewire\Component;

class PersonalData extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Data Diri';
    public $image, $full_name, $phone, $address, $village_id;
    public $original;

    public $village, $district, $regency, $province;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/settings/personal-data')->data;
        $this->image = $data->image;
        $this->full_name = $data->full_name;
        $this->phone = $data->phone;
        $this->address = $data->address;
        $this->village_id = $data->village_id;
        $this->original = $data;
    }
    public function render()
    {
        return view('livewire.auth.settings.personal-data')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function change_data()
    {
        $response = $this->API_post('view/settings/personal-data/change', [
            'image' => $this->image,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'village_id' => $this->village_id,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->refresh();
    }
}
