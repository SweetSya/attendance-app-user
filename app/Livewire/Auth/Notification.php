<?php

namespace App\Livewire\Auth;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;

class Notification extends Component
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'notification';
    protected $api_url = 'view/notification';

    public $title = "Notifikasi";
    public $notifications, $shown_notifications = [];
    public $pagination = [
        'per_page' => 2,
        'count' => 2,
        'page' => 1
    ];

    public function boot()
    {
        $this->refresh();
    }
    public function refresh(bool $refetch = false)
    {
        if ($refetch) {
            $this->setPageSessionRefresh([$this->route_name], 'home');
        }
        $data = $this->getPageSessionData($this->route_name, $this->api_url);
        if (property_exists($data, 'error')) {
            $this->invalidateSession($data);
            return;
        }
        $this->notifications = $data->notifications;
        $this->shown_notifications = array_slice($this->notifications, 0, $this->pagination['count']);
    }

    public function render()
    {
        return view('livewire.auth.notification')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function load_show_notifications()
    {
        $this->pagination['page'] += 1;
        $this->pagination['count'] = $this->pagination['page'] * $this->pagination['per_page'];
        $this->shown_notifications = array_slice($this->notifications, 0, $this->pagination['count']);
    }
    public function mark_as_read($ids)
    {
        $is_all = false;
        if ($ids === 'all') {
            $is_all = true;
            $ids = [];
            foreach ($this->notifications as $notification) {
                if (!$notification->read_at) {
                    array_push($ids, $notification->id);
                }
            }
        } else {
            if (!is_array($ids)) {
                $ids = [$ids];
            }
        }
        $response = $this->API_postJSON('view/notification/read', [
            'notifications' => $ids,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        if ($is_all) {
            $this->dispatch('notify', type: 'success', message: 'Semua notifikasi telah ditandai sebagai dibaca');
        } else {
            $this->dispatch('notify', type: 'success', message: $response->data->message);
        }

        $this->refresh(true);
    }
}
