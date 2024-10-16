<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

trait HasApiHelper
{
    use HasApiConfiguration;

    public function API_get($target_url, $data = [])
    {
        $response = Http::withHeaders($this->API_getHeader())
            ->get($this->API_getURL($target_url), $data);
        return $response;
    }
    public function API_post($target_url, $data = [])
    {
        $response = Http::withHeaders($this->API_getHeader())
            ->post($this->API_getURL($target_url), $data);
        return $response;
    }
    public function API_delete() {}
}
