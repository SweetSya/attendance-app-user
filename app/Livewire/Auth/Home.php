<?php

namespace App\Livewire\Auth;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Livewire\Component;
use stdClass;

class Home extends Component
{
    use HasApiHelper, HasSessionAuthentication;
    public $title = "Home";
    public $distance = 0;
    public $DAY_OFF, $HOLIDAY;

    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances;

    public function boot()
    {
        $data = $this->API_getJSON('view/home');
        $this->employee = $data->employee;
        $this->today = $data->today;
        if (!$this->today) {
            $this->today = new stdClass;
            $this->today->clock_in = null;
            $this->today->clock_out = null;
        }
        $this->office = $data->office;
        $this->company = $data->company;
        $this->total_attend = $data->total_attend;
        $this->total_this_month = $data->total_this_month;
        $this->attendances = $data->attendances;
        // Check if today is day off
        $this->DAY_OFF = false;
        $this->HOLIDAY = false;
        if (!in_array(Carbon::now()->dayOfWeek(), $this->office->work_day)) {
            $this->DAY_OFF = true;
        }
        if ($data->holiday) {
            $this->HOLIDAY = $data->holiday;
        }
    }
    public function render()
    {
        return view('livewire.auth.home')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
}
