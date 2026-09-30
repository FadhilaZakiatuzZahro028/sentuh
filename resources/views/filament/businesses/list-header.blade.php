<div class="sentuh-business-header">

    <div class="sentuh-business-header__intro">
        <div class="sentuh-business-header__text">
            <span class="sentuh-business-header__eyebrow">
                SENTUH / MANAJEMEN DATA
            </span>

            <h1>Bisnis & Organisasi</h1>

            <p>
                Kelola data bisnis, atur informasi,
                dan pantau status halaman digital.
            </p>
        </div>

        {{-- Ilustrasi dekoratif, bukan QR fungsional --}}
        <div class="sentuh-business-header__art" aria-hidden="true">
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
                <x-filament::icon
                    icon="heroicon-o-building-storefront"
                />
            </div>

            <div>
                <strong>Kelola Identitas</strong>
                <span>Nama, kategori, dan logo bisnis</span>
            </div>
        </div>

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-green">
                <x-filament::icon
                    icon="heroicon-o-globe-alt"
                />
            </div>

            <div>
                <strong>Halaman Digital</strong>
                <span>Atur informasi yang ditampilkan</span>
            </div>
        </div>

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-purple">
                <x-filament::icon
                    icon="heroicon-o-chart-bar"
                />
            </div>

            <div>
                <strong>Pantau Status</strong>
                <span>Draft atau terbit</span>
            </div>
        </div>

        <a href="{{ $createUrl }}"
           class="sentuh-business-header__create">
            <x-filament::icon icon="heroicon-o-plus" />
            Tambah Bisnis
        </a>

    </div>
</div>