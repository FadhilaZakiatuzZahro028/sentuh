<div class="sentuh-business-header">

    <div class="sentuh-business-header__intro">

        <div class="sentuh-business-header__text">

            <span class="sentuh-business-header__eyebrow">
                SENTUH / MANAJEMEN KEUANGAN
            </span>

            <h1>Kelola Rekening Kas</h1>

            <p>
                Kelola rekening tunai, bank, dan dompet digital
                sebagai fondasi pencatatan keuangan SENTUH.
            </p>

        </div>

        {{-- Ilustrasi acrylic dekoratif, bukan QR fungsional --}}
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
                <x-filament::icon
                    icon="heroicon-o-building-library"
                />
            </div>

            <div>
                <strong>Kelola Rekening</strong>
                <span>Tunai, bank, dan dompet digital</span>
            </div>

        </div>

        <div class="sentuh-business-header__feature">

            <div class="sentuh-business-header__feature-icon is-green">
                <x-filament::icon
                    icon="heroicon-o-banknotes"
                />
            </div>

            <div>
                <strong>Saldo Awal</strong>
                <span>Nilai awal setiap rekening</span>
            </div>

        </div>

        <div class="sentuh-business-header__feature">

            <div class="sentuh-business-header__feature-icon is-purple">
                <x-filament::icon
                    icon="heroicon-o-shield-check"
                />
            </div>

            <div>
                <strong>Status Rekening</strong>
                <span>Kelola rekening aktif dan nonaktif</span>
            </div>

        </div>

        <a
            href="{{ $createUrl }}"
            class="sentuh-business-header__create"
        >
            <x-filament::icon icon="heroicon-o-plus" />

            Tambah Rekening
        </a>

    </div>

</div>