<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\VAPID;
use Minishlink\WebPush\WebPush;


class PushNotification extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Push Notifikasi';
    public $data, $total, $sub, $registered, $employee;

    public function boot()
    {
        $this->refresh();
    }
    public function refresh(bool $refetch = false)
    {
        $response = $this->API_getJSON(
            'view/settings/push-notification',
            [
                'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName())
            ]
        )->data;
        $this->data = $response->subscriptions ?? [];
        $this->employee = $response->employee ?? null;
        $this->registered = $response->registered  ?? false;
        $this->total = count($this->data);
    }

    public function render()
    {
        return view('livewire.auth.settings.push-notification')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }

    public function save_subscription()
    {
        $response = $this->API_postJSON('view/settings/push-notification/save-subscription', [
            'subscription' => json_encode($this->sub),
            'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName())
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh(true);
    }
    public function delete_subscription($id)
    {
        $response = $this->API_postJSON(
            'view/settings/push-notification/delete-subscription',
            [
                'id' => $id
            ]
        );
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh(true);
    }
    public function test_push_notification($id)
    {
        $response = $this->API_postJSON(
            'view/settings/push-notification/test',
            [
                'id' => $id
            ]
        );
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
}
