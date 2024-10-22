<?php

namespace App\Traits;

trait HasNotifyAction
{
    public function notify_update()
    {
        $this->dispatch('notify', type: 'success', message: 'Perubahan berhasil disimpan');
    }
}
