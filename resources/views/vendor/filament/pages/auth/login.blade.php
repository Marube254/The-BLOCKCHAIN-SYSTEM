<x-filament-panels::page class="fi-simple-page">
    <div class="text-center mb-6">
        <div style="background: transparent; padding: 10px; margin-bottom: 15px;">
            <img src="{{ asset('images/iuea-logo.png') }}" alt="IUEA" style="height: 90px; width: auto; display: block; margin: 0 auto;">
        </div>
        <h2 style="color: #8B0000; font-size: 28px; font-weight: bold; margin-bottom: 5px;">BLOCKCHAIN VOTING SYSTEM</h2>
        <p style="color: #6c757d; font-size: 14px;">Admin Access</p>
        <div style="margin-top: 10px;">
            <span style="background: #f8f9fa; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                <i class="fas fa-link" style="color: #8B0000;"></i> Blockchain Secured
            </span>
        </div>
    </div>

    {{ $this->form }}

    <div class="text-center mt-3">
        <a href="{{ url('/admin/forgot-password') }}" style="color: #8B0000; font-size: 14px; text-decoration: none;">
            Forgot Password?
        </a>
    </div>

    <x-filament::button
        type="submit"
        form="login"
        class="w-full mt-4"
        style="background: #8B0000;"
    >
        {{ __('filament-panels::pages/auth/login.form.actions.authenticate.label') }}
    </x-filament::button>
</x-filament-panels::page>
