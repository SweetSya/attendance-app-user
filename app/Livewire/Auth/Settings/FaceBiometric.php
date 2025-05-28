<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FaceBiometric extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Biometrik Wajah';
    public $face_recognition_status = 0;
    public $employee_name = '';
    public $employee_id = '';
    public $password = '';
    public $password_check_state = false;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/settings/biometric-face')->data;
        $this->face_recognition_status = $data->state;
        $this->employee_id = $data->emp_id;
        $this->employee_name = $data->emp_name;
    }
    public function render()
    {
        return view('livewire.auth.settings.face-biometric')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function match_password()
    {
        $response = $this->API_post('view/settings/biometric-face/check-password', [
            // 'old_password' => $this->old_password,
            'password' => $this->password,
        ]);
        if (!$response->ok()) {
            return false;
        }
        return true;
    }
    // Function for sending the image to the API (Images must be base64 encoded)
    public function save_face_biometric($images)
    {
        $response = $this->API_post('view/settings/biometric-face/save', [
            'images' => $images,
        ]);
        if (!$response->ok()) {
            $this->dispatch('notify', type: 'error', message: 'Terjadi kesalahan saat menyimpan data wajah. Silakan coba lagi.');
            return;
        }
        $this->dispatch('notify', type: 'success', message: 'Data biometrik wajah berhasil disimpan. Harap tunggu proses verifikasi oleh HRDgi.');
        $this->refresh();
    }
}
