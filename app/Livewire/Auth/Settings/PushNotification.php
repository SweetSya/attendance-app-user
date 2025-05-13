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
    public $data, $total, $sub, $registered;

    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $response = $this->API_getJSON(
            'view/settings/push-notification',
            [
                'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName())
            ]
        )->data;
        $this->data = $response->subscriptions ?? [];
        $this->registered = $response->registered ?? false;
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
        $this->refresh();
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
        $this->refresh();
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
        $pushNotif = $response->data->pushData;
        $auth = [
            'VAPID' => [
                'subject' => env("VAPID_EMAIL", "herrysans12@gmail.com"), // can be a mailto: or your website address
                'publicKey' => env("VAPID_PUBLIC_KEY"), // (recommended) uncompressed public key P-256 encoded in Base64-URL
                'privateKey' => env("VAPID_PRIVATE_KEY"), // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
            ],
        ];
        $webpush = new WebPush($auth);
        $webpush->setReuseVAPIDHeaders(true);
        foreach ($pushNotif as $x => $notif) {
            $report = $webpush->sendOneNotification(
                // Decode twice, i still dont know why
                Subscription::create(json_decode(json_decode($notif->subscription, true), true)),
                json_encode([
                    'title' => 'Uji Push Notifikasi',
                    'body' => 'Hai, [' . $response->data->employee->full_name . ']. Jika kamu dapat melihat notifikasi ini, artinya push notifikasi telah berjalan pada perangkat ini.',
                    'url' => '/',
                    'icon' => $response->data->employee->office->company->image
                ]),
                ['TTL' => 5000]
            );

            if (!$report->isSuccess()) {
                Log::error($report->getReason());
            }
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
}
