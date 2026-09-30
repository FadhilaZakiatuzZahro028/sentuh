<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\RedirectResponse;

class DeviceRedirectController extends Controller
{
    public function show(string $deviceCode): RedirectResponse
    {
        $device = Device::query()
            ->with('business')
            ->where('public_code', $deviceCode)
            ->where('status', Device::STATUS_ACTIVE)
            ->whereHas('business', function ($query) {
                $query->where('status', 'published');
            })
            ->firstOrFail();

        return redirect()->route('business.show', [
            'slug' => $device->business->slug,
        ]);
    }
}