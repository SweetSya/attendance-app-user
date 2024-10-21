<?php

namespace App\Livewire\Auth;

use App\Traits\HasApiHelper;
use Carbon\Carbon;
use Livewire\Component;
use stdClass;

class Attendance extends Component
{

    use HasApiHelper;
    public $title = "Absensi";

    public $DAY_OFF, $HOLIDAY;
    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances;
    public $absence_reason, $absence_note;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/attendance');
        $this->employee = $data->employee;
        $this->today = $data->today;
        if (!$this->today) {
            $this->today = new stdClass;
            $this->today->clock_in = null;
            $this->today->clock_out = null;
        }
        $this->office = $data->office;
        $this->company = $data->company;
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
        return view('livewire.auth.attendance')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function clock_employee_in($position)
    {
        $response = $this->API_post('view/attendance/clock-in', [
            'position' => $position,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->refresh();
    }
    public function clock_employee_out($position)
    {
        $response = $this->API_post('view/attendance/clock-out', [
            'position' => $position,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->refresh();
    }
    public function clock_employee_absence()
    {
        $response = $this->API_post('view/attendance/absence', [
            'reason' => $this->absence_reason,
            'note' => $this->absence_note,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->refresh();
    }
}
