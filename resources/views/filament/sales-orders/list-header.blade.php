<div class="sentuh-business-header sentuh-sales-header">

    <div class="sentuh-business-header__intro">
        <div class="sentuh-business-header__text">

            <span class="sentuh-business-header__eyebrow">
                SENTUH / MANAJEMEN TRANSAKSI
            </span>

            <h1>Kelola Penjualan</h1>

            <p>
                Catat pesanan pelanggan, kelola nilai transaksi,
                dan pantau progres pengerjaan produk SENTUH.
            </p>

        </div>

        {{-- Ilustrasi dekoratif, bukan QR fungsional --}}
        <div class="sentuh-business-header__art"
             aria-hidden="true">

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
                    icon="heroicon-o-shopping-bag"
                />
            </div>

            <div>
                <strong>Catat Pesanan</strong>
                <span>Kelola transaksi pelanggan</span>
            </div>
        </div>

        <div class="sentuh-business-header__feature">
            <div class="sentuh-business-header__feature-icon is-green">
                <x-filament::icon
                    icon="heroicon-o-banknotes"
                />
            </div>

            <div>
                <strong>Kelola Biaya</strong>
                <span>Estimasi dan biaya produksi</span>
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
                <span>Progres pengerjaan pesanan</span>
            </div>
        </div>

        <a href="{{ $createUrl }}"
           class="sentuh-business-header__create">

            <x-filament::icon icon="heroicon-o-plus" />

            Tambah Pesanan
        </a>

    </div>
</div>