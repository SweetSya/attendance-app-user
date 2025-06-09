<?php

namespace App\Http\Controllers;

use App\Traits\HasSessionAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AuthenticateController extends Controller
{
    use HasSessionAuthentication;

    public function add_session_page_refresh(Request $request)
    {
        $refresh_pages = Session::get('refresh_pages', []);
        $to_be_refreshed = explode(',', $request->name);
        foreach ($to_be_refreshed as $page) {
            if (!in_array($page, $refresh_pages, true)) {
                array_push($refresh_pages, $page);
            }
        }
        Session::put('refresh_pages', $refresh_pages);
        return response()->json([
            'message' => 'Halaman berhasil ditambahkan ke daftar refresh',
        ]);
    }
    public function remove_page_session(Request $request)
    {
        // Remove all pages session
        session()->forget('pages');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        session()->flash('success', 'Berhasil logout, selamat melanjutkan aktivitas!');
        return redirect('/');
    }

    public function verify_email(Request $request)
    {
        // Check for q in url
        if (!$request->has('q')) {
            session()->flash('error', 'Tidak dapat memverifikasi token verifikasi email');
            return redirect('/');
        }
        $token = $request->q;
        // Check for q in database
        $response =  $this->API_getJSON(
            'verify-email',
            [
                'q' => $token
            ]
        );
        if ($response->status != 200) {
            session()->flash('error', $response->data->message);
        } else {
            session()->flash('success', $response->data->message);
        }
        $response = $this->API_get(
            'renew-session',
        );
        if ($response->ok()) {
            return redirect('/home');
        } else {
            return redirect('/');
        }
    }
}
