<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Livewire\Component;
use stdClass;

class Attendance extends BaseComponent
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'attendance';
    protected $api_url = 'view/attendance';

    public $title = "Kehadiran";

    public $DAY_OFF, $HOLIDAY, $VACATION;
    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances, $face_state;
    public $absence_reason, $absence_note;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh(bool $refetch = false)
    {
        // If refetch is true, we will force to fetch data from API
        if ($refetch) {
            $this->setPageSessionRefresh([$this->route_name, 'home', 'history']);
        }
        $data = $this->getPageSessionData($this->route_name, $this->api_url);
        if (property_exists($data, 'error')) {
            $this->invalidateSession($data);
            return;
        }
        $this->employee = $data->employee;
        $this->today = $data->today;
        if (!$this->today) {
            $this->today = new stdClass;
            $this->today->clock_in = null;
            $this->today->clock_out = null;
        }
        $this->office = $data->office;
        $this->company = $data->company;
        $this->face_state = $data->face_biometric;
        // Check if today is day off
        $this->DAY_OFF = false;
        $this->VACATION = false;
        $this->HOLIDAY = false;
        if (!in_array(Carbon::now()->dayOfWeek(), $this->office->work_day)) {
            $this->DAY_OFF = true;
        }
        if ($this->employee->status == 'vacation') {
            $this->VACATION = true;
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
    public function clock_employee_face($base64_image, $position)
    {
        // Check for base64_image and position if null
        if (is_null($position)) {
            $this->dispatch('notify', type: 'error', message: 'Posisi lokasi masih kosong');
            $this->dispatch('set_face_scanning', scanning: false);
            return false;
        }
        if (is_null($base64_image)) {
            $this->dispatch('notify', type: 'error', message: 'Gambar wajah lokasi masih kosong');
            $this->dispatch('set_face_scanning', scanning: false);
            return false;
        }
        $response = $this->API_postJSON('view/attendance/clock-face', [
            'face' => $base64_image,
            'position' => $position,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            $this->dispatch('set_face_scanning', scanning: false);
            return false;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->dispatch('stop_face_recog');
        $this->dispatch('set_drawer', title: 'Verifikasi Kehadiran', section: 'checkedin');
        $this->dispatch('clear_after_done');
        $this->dispatch('set_face_scanning', scanning: false);
        $this->refresh(true);
        return true;
    }
    public function clock_employee_in($position)
    {
        $response = $this->API_postJSON('view/attendance/clock-in', [
            'position' => $position,
        ]);
        if ($response->status != 200) {
            $this->dispatch('clear_after_error');
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('stop_face_recog');
        $this->dispatch('set_drawer', title: 'Verifikasi Kehadiran', section: 'checkedin');
        $this->dispatch('clear_after_done');
        $this->refresh(true);
    }
    public function clock_employee_out($position)
    {
        if (is_null($position)) {
            $this->dispatch('notify', type: 'error', message: 'Posisi lokasi masih kosong');
            return false;
        }
        $response = $this->API_postJSON('view/attendance/clock-out', [
            'position' => $position,
        ]);
        if ($response->status != 200) {
            $this->dispatch('clear_after_error');
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('set_drawer', title: 'Verifikasi Clock Out', section: 'checkedout');
        $this->dispatch('clear_after_done');
        $this->refresh(true);
    }
    public function clock_employee_absence($position)
    {
        $response = $this->API_postJSON('view/attendance/absence', [
            'reason' => $this->absence_reason,
            'note' => $this->absence_note,
            'position' => $position,
        ]);
        if ($response->status != 200) {
            $this->dispatch('clear_after_error');
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('set_drawer', title: 'Pengajuan Izin', section: 'absenced');
        $this->dispatch('clear_after_done');
        $this->refresh(true);
    }
}
