<?php

namespace App\Livewire\Auth\Others;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;

class Vacation extends Component
{
    use HasApiHelper, HasSessionAuthentication;

    protected $listeners = [
        'updateDateRange' => 'update_date_range',
    ];


    protected $route_name = 'vacation';
    protected $api_url = 'view/vacation';


    public $title = "Pengajuan Cuti";
    public $start, $end, $note;
    public $vacations;

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

        $this->vacations = $data->vacations;
    }
    public function render()
    {
        return view('livewire.auth.others.vacation')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function update_date_range($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    public function create()
    {
        $response = $this->API_postJSON('view/vacation/create', [
            'start' => $this->start,
            'end' => $this->end,
            'note' => $this->note,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->start = null;
        $this->end = null;
        $this->note = null;
        $this->refresh(true);
    }
    // public function paginate($url)
    // {
    //     $clean_url = str_replace($this->API_getURL(''), '', $url);
    //     $data = $this->API_getJSON($clean_url)->data;
    //     $this->vacations = $data;
    // }
    public function cancel($id)
    {
        $response = $this->API_postJSON('view/vacation/cancel', [
            'vacation_id' => $id,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh(true);
    }
}
