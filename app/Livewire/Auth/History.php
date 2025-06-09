<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;
use stdClass;

class History extends BaseComponent
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'history';
    protected $api_url = 'view/history';

    public $title = "Histori";
    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances, $shown_attendances = [];
    public $pagination = [
        'per_page' => 4,
        'count' => 4
    ];

    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->getPageSessionData($this->route_name, $this->api_url);
        if (property_exists($data, 'error')) {
            $this->invalidateSession($data);
            return;
        }
        
        $this->employee = $data->employee;
        $this->office = $data->office;
        $this->company = $data->company;
        $this->total_attend = $data->total_attend;
        $this->total_this_month = $data->total_this_month;
        $this->attendances = $data->attendances;
    }

    public function render()
    {
        $this->load_show_attendaces();
        return view('livewire.auth.history')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function load_show_attendaces()
    {
        $this->shown_attendances = array_slice($this->attendances, 0, $this->pagination['count']);
    }
}
