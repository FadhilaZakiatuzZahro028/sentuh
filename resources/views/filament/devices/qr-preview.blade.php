<div class="flex flex-col items-center gap-5 p-4">

    <img
        src="{{ $qrImage }}"
        alt="QR Code perangkat SENTUH"
        class="h-64 w-64 max-w-full bg-white p-2"
        width="256"
        height="256"
    >
    <div>
    {{ $action->getModalAction('downloadQr') }}
</div>

    <div class="w-full space-y-2 text-center">
        <p class="text-sm font-semibold">
            URL Permanen Perangkat
        </p>

        <p class="break-all text-sm text-gray-600 dark:text-gray-300">
            {{ $deviceUrl }}
        </p>
    </div>

    <p class="text-center text-xs text-gray-500">
        QR Code ini digunakan untuk membuka
        halaman bisnis melalui perangkat SENTUH.
    </p>

</div>