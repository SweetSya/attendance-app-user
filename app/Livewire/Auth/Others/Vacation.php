<?php

namespace App\Livewire\Auth\Others;

use App\Traits\HasApiHelper;
use Livewire\Component;

class Vacation extends Component
{
    use HasApiHelper;
    public $title = "Pengajuan Cuti";
    public $start, $end, $note;
    public $vacations;

    public function boot()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $data = $this->API_getJSON('view/vacations')->data;
        $this->vacations = $data;
    }
    public function render()
    {
        return view('livewire.auth.others.vacation')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function create()
    {
        $response = $this->API_postJSON('view/vacations/create', [
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
        $this->refresh();
    }
    // public function paginate($url)
    // {
    //     $clean_url = str_replace($this->API_getURL(''), '', $url);
    //     $data = $this->API_getJSON($clean_url)->data;
    //     $this->vacations = $data;
    // }
    public function cancel($id)
    {
        $response = $this->API_postJSON('view/vacations/cancel', [
            'vacation_id' => $id,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
}
