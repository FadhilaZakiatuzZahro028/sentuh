<?php

namespace App\Filament\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Support\Enums\Width;
use Filament\Schemas\Components\Component;

class AdminLogin extends BaseLogin
{
    public function getHeading(): string | Htmlable | null
    {
        // Pertahankan heading bawaan jika MFA digunakan.
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return parent::getHeading();
        }

        // Hilangkan judul besar "Sign in".
        return null;
    }

    public function getTitle(): string | Htmlable
    {
        return 'Login Admin SENTUH';
    }

    protected string $view = 'filament.auth.admin-login';

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    protected function getAuthenticateFormAction(): Action
{
    return parent::getAuthenticateFormAction()
        ->label('Masuk')
        ->extraAttributes([
            'class' => 'sentuh-login-submit',
        ]);
}

    protected function getEmailFormComponent(): Component
{
    return parent::getEmailFormComponent()
        ->label('Email');
}

protected function getPasswordFormComponent(): Component
{
    return parent::getPasswordFormComponent()
        ->label('Kata Sandi');
}

protected function getRememberFormComponent(): Component
{
    return parent::getRememberFormComponent()
        ->label('Ingat saya');
}
}
