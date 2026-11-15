<?php

namespace App\Support;

use App\Models\LogAktivitas;

class ActivityLogger
{
    public static function record(string $activity): void
    {
        $userId = auth()->id();
        if (!$userId) {
            return;
        }

        LogAktivitas::create([
            'id_user' => $userId,
            'aktivitas' => $activity,
            'waktu_aktivitas' => now(),
        ]);
    }
}
