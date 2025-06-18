<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use stdClass;

class Home extends BaseComponent
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'home';
    protected $api_url = 'view/home';

    public $title = "Home";
    public $distance = 0;
    public $DAY_OFF, $HOLIDAY, $VACATION;

    public $employee, $office, $company, $today, $total_attend, $total_this_month, $attendances, $is_admin, $admin_route, $total_notifications;

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
    public function refresh(bool $refetch = false)
    {
        // If refetch is true, we will force to fetch data from API
        if ($refetch) {
            $this->setPageSessionRefresh([$this->route_name, 'home', 'history']);
        }
        $data = $this->getPageSessionData($this->route_name, $this->api_url);
        if (property_exists($data, 'error')) {
            $this->invalidateSession($data);
        }
        // Get home data from session
        $this->employee = $data->employee;
        $this->today = $data->today;
        $this->is_admin = $data->is_admin;
        if ($this->is_admin) {
            $token_session = Auth::user()->auth_access_token;
            $token_device = Auth::user()->device_uuid;
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
        $this->total_notifications = $data->total_notifications;
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
            'token_session' => Hash::make(Auth::user()->auth_access_token),
            'device_uuid' => Hash::make(Auth::user()->device_uuid),
            'ref' => Hash::make(env('APP_URL')),
        ]);
        $data = $response->json();
        if (!$response->ok()) {
            $this->dispatch('notify', type: 'error', message: $data['message'] ?? 'Gagal mengakses halaman admin');
            return $this->redirect('/home', navigate: true);
        }
        $this->dispatch('notify', type: 'success', message: $data['message']);
        return Redirect::to($this->admin_route);
    }
}
