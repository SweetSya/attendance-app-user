<?php

namespace App\Livewire\Auth;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use stdClass;

class Home extends Component
{
    use HasApiHelper, HasSessionAuthentication;
    public $title = "Home";
    public $distance = 0;
    public $DAY_OFF, $HOLIDAY, $VACATION;

    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances, $is_admin, $admin_route;

    public function boot()
    {
        $this->refresh();
        if (session()->has('welcome')) {
            $this->dispatch('notify', type: 'success', message: 'Selamat datang kembali, ' . $this->employee->full_name);
        }
        if (session()->has('logged_in')) {
            $this->dispatch('notify', type: 'success', message: 'Sudah autentikasi menggunakan akun ' . $this->employee->full_name);
        }
        if (session()->has('error')) {
            $this->dispatch('notify', type: 'error', message: session()->get('error'));
        }
        if (session()->has('success')) {
            $this->dispatch('notify', type: 'success', message: session()->get('success'));
        }
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/home')->data;
        $this->employee = $data->employee;
        $this->today = $data->today;
        $this->is_admin = $data->is_admin;
        if ($this->is_admin) {
            $token_session = Cookie::get($this->COOKIES_getSessionName());
            $token_device = Cookie::get($this->COOKIES_getDeviceUUIDSessionName());
            $this->admin_route = env('APP_API_HOST') . '/login-with-session-employee?emp=' . Hash::make($this->employee->id) . '&token_session=' . Hash::make($token_session) . '&device_uuid=' . Hash::make($token_device) . '&ref=' . Hash::make(env('APP_URL'));
        }
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
        return view('livewire.auth.home')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
    public function redirect_admin()
    {
        $response = $this->API_get('check-login-with-session-employee', [
            'emp' => Hash::make($this->employee->id),
            'token_session' => Hash::make(Cookie::get($this->COOKIES_getSessionName())),
            'device_uuid' => Hash::make(Cookie::get($this->COOKIES_getDeviceUUIDSessionName())),
            'ref' => Hash::make(env('APP_URL')),
        ]);
        $data = $response->json();
        if (!$response->ok()) {
            $this->dispatch('notify', type: 'error', message: $data['message'] ?? 'Gagal mengakses halaman admin');
            return;
        }
        $this->dispatch('notify', type: 'success', message: $data['message']);
        return Redirect::to($this->admin_route);
    }
}
