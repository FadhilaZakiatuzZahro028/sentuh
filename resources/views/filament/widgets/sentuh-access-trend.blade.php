<x-filament-widgets::widget>
    <x-filament::section
        heading="Tren Akses QR/NFC"
        description="Aktivitas akses melalui perangkat SENTUH"
    >
        <div
            class="sentuh-empty sentuh-empty--trend"
            role="status"
        >
            <div class="sentuh-empty__icon-wrap">
                <x-filament::icon
                    icon="heroicon-o-chart-bar"
                    class="sentuh-empty__icon"
                />
            </div>

            <span class="sentuh-empty__badge">
                Menunggu Data
            </span>

            <h3 class="sentuh-empty__title">
                Belum ada data akses
            </h3>

            <p class="sentuh-empty__description">
                Grafik QR dan NFC akan ditampilkan
                setelah pencatatan akses tersedia.
            </p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>