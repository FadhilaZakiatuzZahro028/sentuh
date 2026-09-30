
<div class="sentuh-login">
    <section
    class="sentuh-login-visual"
    role="img"
    aria-label="SENTUH. Satu Sentuhan, Banyak Koneksi. Ilustrasi produk acrylic QR dan NFC."
></section>

    <section class="sentuh-login-form-panel">
        <div class="sentuh-login-form-content">
            <div class="sentuh-login-heading">
                <span class="sentuh-login-eyebrow">ADMIN DASHBOARD</span>
                <h2>Selamat datang.</h2>
                <p>Masukkan akun admin untuk melanjutkan.</p>
            </div>

            {{ $this->content }}

            <p class="sentuh-login-footer">
    SENTUH &mdash; Platform Digital Bisnis
</p>
        </div>
    </section>
</div>


<style>
    .sentuh-login {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        width: 100%;
        max-width: 1380px;
        min-height: 680px;
        margin: 20px auto;
        overflow: hidden;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 16px 60px rgba(16, 35, 63, .08);
        font-family: inherit;
    }

    .sentuh-login-visual {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 42px 48px;
        background: #10233f;
        color: #ffffff;
    }

    .sentuh-login-brand {
        font-size: 23px;
        font-weight: 800;
        letter-spacing: .12em;
    }

    .sentuh-login-brand span {
        color: #75a7ff;
    }

    .sentuh-login-artwork {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
    }

    .sentuh-login-artwork-placeholder {
        padding: 85px 35px;
        border: 1px dashed rgba(255, 255, 255, .5);
        border-radius: 18px;
        color: rgba(255, 255, 255, .65);
        font-size: 12px;
        letter-spacing: .12em;
        text-align: center;
    }

    .sentuh-login-message p {
        margin-bottom: 12px;
        color: #a4c2f0;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .14em;
    }

    .sentuh-login-message h1 {
        margin-bottom: 16px;
        color: #ffffff;
        font-size: clamp(27px, 3vw, 39px);
        font-weight: 750;
        line-height: 1.2;
    }

    .sentuh-login-message span {
        display: block;
        max-width: 390px;
        color: #d1dbeb;
        font-size: 14px;
        line-height: 1.7;
    }

    .sentuh-login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 65px 55px;
        background: #ffffff;
        color: #10233f;
    }

    .sentuh-login-form-content {
        width: 100%;
        max-width: 420px;
    }

    .sentuh-login-heading {
        margin-bottom: 32px;
    }

    .sentuh-login-eyebrow {
        display: block;
        margin-bottom: 12px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 750;
        letter-spacing: .12em;
    }

    .sentuh-login-heading h2 {
        margin-bottom: 9px;
        color: #10233f;
        font-size: 32px;
        font-weight: 750;
    }

    .sentuh-login-heading p,
    .sentuh-login-footer {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .sentuh-login-footer {
        margin-top: 38px;
        text-align: center;
        font-size: 12px;
    }

    @media (max-width: 850px) {
        .sentuh-login {
            display: block;
            min-height: 0;
            margin: 0 auto;
            border-radius: 0;
            box-shadow: none;
        }

        .sentuh-login-visual {
            padding: 24px;
        }

        .sentuh-login-artwork,
        .sentuh-login-message {
            display: none;
        }

        .sentuh-login-form-panel {
            padding: 55px 25px;
        }
    }

/* Perbaikan ruang tambahan dari layout Filament */
body:has(.sentuh-login) .fi-simple-main {
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
    border: 0 !important;
}

body:has(.sentuh-login) .fi-simple-main-ctn {
    width: 100%;
    padding: 16px 24px;
}

/* Proporsi panel login */
.sentuh-login {
    width: 100%;
    max-width: 1160px;
    min-height: min(620px, calc(100dvh - 40px));
    margin: 0 auto;
}

.sentuh-login-visual {
    padding: 30px 40px;
}

.sentuh-login-artwork {
    min-height: 160px;
}

.sentuh-login-artwork-placeholder {
    padding: 50px 24px;
}

.sentuh-login-form-panel {
    padding: 32px 44px;
}

.sentuh-login-heading {
    margin-bottom: 22px;
}

.sentuh-login-heading h2 {
    font-size: 29px;
}

.sentuh-login-footer {
    margin-top: 20px;
}

/* Tampilan ponsel */
@media (max-width: 850px) {
    body:has(.sentuh-login) .fi-simple-main-ctn {
        padding: 0;
    }

    .sentuh-login {
        min-height: 100dvh;
        margin: 0;
        border-radius: 0;
    }

    .sentuh-login-visual {
        padding: 22px 26px;
    }

    .sentuh-login-form-panel {
        padding: 36px 26px;
    }
}


/* Visual resmi panel kiri login SENTUH */
.sentuh-login-visual {
    display: block;
    min-height: 620px;
    padding: 0;

    background-color: #0b1424;
    background-image: url('/images/sentuh-login-panel.webp');
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
}

/* Pada ponsel, prioritaskan formulir login */
@media (max-width: 850px) {
    .sentuh-login-visual {
        display: none;
    }
}

/* Penyempurnaan proporsi desktop */
.sentuh-login {
    height: min(700px, calc(100dvh - 32px));
    min-height: 0;
}

.sentuh-login-visual {
    min-height: 0;
}

.sentuh-login-form-panel {
    padding: 24px 42px;
}

/* Tetap nyaman digunakan melalui ponsel */
@media (max-width: 850px) {
    .sentuh-login {
        height: auto;
        min-height: 100dvh;
    }

    .sentuh-login-form-panel {
        padding: 36px 26px;
    }
}

/* Tombol utama Login Admin SENTUH */
.sentuh-login .sentuh-login-submit {
    background-color: #2563EB !important;
    color: #FFFFFF !important;
}

.sentuh-login .sentuh-login-submit:hover {
    background-color: #1D4ED8 !important;
}

</style>
