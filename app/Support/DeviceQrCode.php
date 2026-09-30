<?php

namespace App\Support;

use App\Models\Device;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class DeviceQrCode
{
    public function url(Device $device): string
    {
        return rtrim(config('app.url'), '/')
            . route('device.redirect', [
                'deviceCode' => $device->public_code,
            ], false)
            . '?via=qr';
    }

    public function image(Device $device): string
    {
        return (new QRCode())->render(
            $this->url($device)
        );
    }

    public function svg(Device $device): string
{
    $options = new QROptions();
    $options->outputBase64 = false;

    return (new QRCode($options))->render(
        $this->url($device)
    );
}
}