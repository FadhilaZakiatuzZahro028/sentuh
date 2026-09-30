<div class="sentuh-business-header sentuh-devices-header">

    <div class="sentuh-business-header__intro">
        <div class="sentuh-business-header__text">
            <span class="sentuh-business-header__eyebrow">
                SENTUH / MANAJEMEN PERANGKAT
            </span>

            <h1>Perangkat QR & NFC</h1>

            <p>
                Kelola perangkat acrylic, kode permanen,
                dan akses halaman digital melalui SENTUH.
            </p>
        </div>

        {{-- Ilustrasi produk, bukan QR yang dapat dipindai --}}
        <div
            class="sentuh-business-header__art"
            aria-hidden="true"
        >
            <div class="sentuh-business-header__circle"></div>

            <div class="sentuh-business-header__device">
                <span class="sentuh-business-header__brand">
                    sentuh<span>.</span>
                </span>

                <x-filament::icon
                    icon="heroicon-o-qr-code"
                    class="sentuh-business-header__qr"
                />

                <x-filament::icon
                    icon="heroicon-o-wifi"
                    class="sentuh-business-header__nfc"
                />
            </div>
        </div>
    </div>

    <div class="sentuh-business-header__bottom">

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-blue">
                <x-filament::icon icon="heroicon-o-key" />
            </div>

            <div>
                <strong>Kode Permanen</strong>
                <span>Identitas unik setiap perangkat</span>
            </div>
        </div>

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-green">
                <x-filament::icon icon="heroicon-o-qr-code" />
            </div>

            <div>
                <strong>QR Code</strong>
                <span>Pratinjau dan unduh SVG</span>
            </div>
        </div>

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-purple">
                <x-filament::icon icon="heroicon-o-shield-check" />
            </div>

            <div>
                <strong>Status Perangkat</strong>
                <span>Aktif atau nonaktif</span>
            </div>
        </div>

        <a
            href="{{ $createUrl }}"
            class="sentuh-business-header__create"
        >
            <x-filament::icon icon="heroicon-o-plus" />

            Tambah Perangkat
        </a>
    </div>
</div>