<x-filament-widgets::widget>
    <section class="sentuh-hero">
        <div class="sentuh-hero__content">
            <span class="sentuh-hero__eyebrow">SENTUH / ADMIN PANEL</span>

            <h2 class="sentuh-hero__title">Satu Sentuhan, Banyak Koneksi.</h2>

            <p class="sentuh-hero__description">
    Kelola bisnis dan perangkat QR/NFC
    dalam satu dashboard.
</p>

            <div class="sentuh-hero__actions">
                <a href="{{ $createBusinessUrl }}" class="sentuh-hero__button">
                    Tambah Bisnis
                </a>

            </div>
        </div>

        <div class="sentuh-hero__visual" aria-hidden="true">
            <div class="sentuh-hero__halo"></div>
            <div class="sentuh-hero__platform"></div>

            <div class="sentuh-hero__device">
                <div class="sentuh-hero__device-brand">
                    sentuh<span>.</span>
                </div>

                <div class="sentuh-hero__qr">
                    @for ($i = 0; $i < 25; $i++)
                        <span class="{{ in_array($i, [0, 1, 4, 6, 8, 10, 12, 14, 15, 18, 20, 21, 24]) ? 'is-filled' : '' }}"></span>
                    @endfor
                </div>

                <div class="sentuh-hero__nfc">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </section>
</x-filament-widgets::widget>