<?php

namespace App\Livewire\Auth\Settings;

use App\Livewire\BaseComponent;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;

class Email extends BaseComponent
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'settings/email';
    protected $api_url = 'view/settings/email';

    public $title = 'Pengaturan - Email';
    public $email, $verified_at, $verify_issue_code, $existing_issue, $issue_state;
    public $new_email_issued = false;
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
        $this->email = $data->email;
        $this->verified_at = $data->verified_at;
        $this->existing_issue = $data->existing_issue;
        $this->original = $data;
        // Issue state
        if ($this->existing_issue) {
            // Check if its status pending and valid_until still valid
            if ($this->existing_issue->status === 'pending' && $this->existing_issue->valid_until >= now()) {
                $this->issue_state = 'pending';
            } elseif ($this->existing_issue->status === 'approval') {
                $this->issue_state = 'approval';
            } else {
                $this->issue_state = 'expired';
            }
        } else {
            $this->issue_state = false;
        }
    }
    public function render()
    {
        return view('livewire.auth.settings.email')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function change_email()
    {
        $response = $this->API_postJSON('view/settings/email/change', [
            'email' => $this->email,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message ?? 'Gagal mengubah email');
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message ?? 'Harap cek email baru untuk kode verifikasi');
        $this->new_email_issued = true;
        $this->refresh(true);
    }
    public function resend_change_email_token()
    {
        $response = $this->API_postJSON('view/settings/email/change', [
            'email' => $this->existing_issue->email,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message ?? 'Gagal mengirimkan permintaan, harap cuba lagi');
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message ?? 'Harap cek email baru untuk kode verifikasi');
        $this->new_email_issued = true;
        $this->refresh(true);
    }
    public function send_verification_email()
    {
        $response = $this->API_postJSON('send-email-verification', [
            'email' => $this->email,
            'host' => env('APP_URL')
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
    public function verify_issue_new_email()
    {
        $response = $this->API_postJSON('view/settings/email/verify-change', [
            'email' => $this->email,
            'code' => $this->verify_issue_code,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message ?? 'Kode verifikasi tidak valid');
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message ?? 'Email berhasil diverifikasi, harap tunggu approval dari HR');
        $this->new_email_issued = false;
        $this->refresh(true);
    }
}
