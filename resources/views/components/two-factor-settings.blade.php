<?php

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Component;

new class extends Component
{
    public string $code = '';

    public bool $confirming = false;

    public array $recoveryCodes = [];

    public ?string $qrCodeSvg = null;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->two_factor_secret && ! $user->two_factor_confirmed_at) {
            $this->confirming = true;
            $this->qrCodeSvg = $user->twoFactorQrCodeSvg();
        }
    }

    public function enable(EnableTwoFactorAuthentication $enable): void
    {
        $enable(Auth::user());

        $this->confirming = true;
        $this->qrCodeSvg = Auth::user()->fresh()->twoFactorQrCodeSvg();
    }

    public function confirm(ConfirmTwoFactorAuthentication $confirm): void
    {
        $this->validate([
            'code' => 'required|string',
        ]);

        try {
            $confirm(Auth::user(), $this->code);

            $this->confirming = false;
            $this->code = '';
            $this->recoveryCodes = json_decode(decrypt(Auth::user()->fresh()->two_factor_recovery_codes), true);

            session()->flash('success', 'Twee-factorauthenticatie is ingeschakeld.');
        } catch (\Exception $e) {
            $this->addError('code', 'De ingevoerde code is onjuist.');
        }
    }

    public function disable(DisableTwoFactorAuthentication $disable): void
    {
        $disable(Auth::user());

        $this->confirming = false;
        $this->qrCodeSvg = null;

        session()->flash('success', 'Twee-factorauthenticatie is uitgeschakeld.');
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate): void
    {
        $generate(Auth::user());

        $this->recoveryCodes = json_decode(decrypt(Auth::user()->fresh()->two_factor_recovery_codes), true);

        session()->flash('success', 'Nieuwe herstelcodes gegenereerd.');
    }
};
?>

<div style="max-width: 500px">
    @if (session('success'))
        <div
            style="
                color: #0a7d0a;
                background: #e8f5e9;
                padding: 8px 12px;
                margin-bottom: 12px;
                border-radius: 3px;
                font-size: 13px;
            "
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            style="
                color: #c62828;
                background: #ffebee;
                padding: 8px 12px;
                margin-bottom: 12px;
                border-radius: 3px;
                font-size: 13px;
            "
        >
            {{ session('error') }}
        </div>
    @endif

    @php $user = auth()->user(); @endphp

    @if ($user->two_factor_confirmed_at && ! $confirming)
        <div
            style="
                background: #e8f5e9;
                border: 1px solid #a5d6a7;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 16px;
            "
        >
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #0a7d0a; font-weight: 600">
                ✓ Twee-factorauthenticatie is ingeschakeld
            </p>
            <p style="margin: 0; font-size: 13px; color: #555">Je account is beveiligd met een authenticator-app.</p>
        </div>

        <button
            wire:click="regenerateRecoveryCodes"
            style="
                background: #6c757d;
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 13px;
                margin-right: 8px;
            "
        >
            Nieuwe herstelcodes genereren
        </button>

        <button
            wire:click="disable"
            onclick="return confirm('Weet je zeker dat je 2FA wilt uitschakelen?');"
            style="
                background: #dc3545;
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 13px;
            "
        >
            Uitschakelen
        </button>

        @if (! empty($recoveryCodes))
            <div style="margin-top: 16px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 6px; padding: 16px">
                <p style="font-size: 13px; font-weight: 600; margin: 0 0 8px 0">Herstelcodes (bewaar deze veilig):</p>
                <div style="font-family: monospace; font-size: 13px; line-height: 1.8">
                    @foreach ($recoveryCodes as $recoveryCode)
                        {{ $recoveryCode }}<br
                         />
                    @endforeach
                </div>
            </div>
        @endif
    @elseif ($confirming)
        <div
            style="
                background: #fff8e1;
                border: 1px solid #ffe082;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 16px;
            "
        >
            <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 600">
                Scan deze QR-code met je authenticator-app (bijv. Google Authenticator):
            </p>

            <div style="background: white; padding: 12px; display: inline-block; border-radius: 6px">
                {!! $qrCodeSvg !!}
            </div>

            <form wire:submit="confirm" style="margin-top: 16px">
                <div class="form-group">
                    <label>Voer de 6-cijferige code in</label>
                    <input
                        type="text"
                        wire:model="code"
                        inputmode="numeric"
                        maxlength="6"
                        autocomplete="off"
                        style="max-width: 150px; border: 1px solid #000"
                    />
                    @error('code')
                        <div style="margin-top: 6px; font-size: 13px; color: #d32f2f">{{ $message }}</div>
                    @enderror
                </div>

                <button
                    type="submit"
                    style="
                        background: #007bff;
                        color: white;
                        border: none;
                        padding: 6px 12px;
                        border-radius: 3px;
                        cursor: pointer;
                        font-size: 13px;
                    "
                >
                    Bevestigen
                </button>
            </form>
        </div>
    @else
        <div
            style="
                background: #ffebee;
                border: 1px solid #ef9a9a;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 16px;
            "
        >
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #c62828; font-weight: 600">
                ⚠ Twee-factorauthenticatie is verplicht
            </p>
            <p style="margin: 0; font-size: 13px; color: #555">
                Je moet 2FA instellen voordat je verder kunt met de applicatie.
            </p>
        </div>

        <button
            wire:click="enable"
            style="
                background: #007bff;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 13px;
            "
        >
            Twee-factorauthenticatie instellen
        </button>
    @endif
</div>
