@section('title', __('change_password.title'))

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">
        <h1 class="change-password-title">
           <i class="bi bi-shield-lock-fill" style="color:#ff6600"></i>
            {{ __('change_password.heading') }}
        </h1>

        <p class="change-password-subtitle">
            {{ __('change_password.subtitle') }}
        </p>
    </div>

    @if (session()->has('message'))
        <div wire:poll.4s class="alert alert-success rounded-4 shadow-sm text-center mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">

            <div class="change-password-card">

                <form wire:submit.prevent="updatePassword({{ auth()->id() }})">

                    <div class="mb-4">
                        <label for="newpassword" class="form-label fw-semibold">
                            {{ __('change_password.new_password') }}
                        </label>

                        <input wire:model.defer="newpassword"
                               type="password"
                               id="newpassword"
                               class="form-control change-password-input @error('newpassword') is-invalid @enderror"
                               placeholder="{{ __('change_password.new_password_placeholder') }}">

                        @error('newpassword')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror

                        <div class="form-text mt-2">
                            {{ __('change_password.password_help') }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="newpassword_confirmation" class="form-label fw-semibold">
                            {{ __('change_password.confirm_password') }}
                        </label>

                        <input wire:model.defer="newpassword_confirmation"
                               type="password"
                               id="newpassword_confirmation"
                               class="form-control change-password-input @error('newpassword_confirmation') is-invalid @enderror"
                               placeholder="{{ __('change_password.confirm_password_placeholder') }}">

                        @error('newpassword_confirmation')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="change-password-button w-100">
                       
                        {{ __('change_password.button') }}
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>

<style>
    .change-password-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: #212529;
    }

    .change-password-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .change-password-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1.2rem;
        padding: 1.8rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .22s ease;
    }

    .change-password-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .change-password-input {
        border-radius: 999px;
        min-height: 50px;
        border: 1px solid #dee2e6;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
        padding-left: 1.1rem;
    }

    .change-password-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30,64,175,.12);
    }

    .change-password-button {
        border: none;
        border-radius: 999px;
        min-height: 50px;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        transition: .22s ease;
        box-shadow: 0 8px 20px rgba(30,64,175,.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
    }

    .change-password-button:hover {
        background: #3157d5;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30,64,175,.28);
    }

    @media(max-width: 575px) {
        .change-password-title {
            font-size: 2rem;
        }

        .change-password-card {
            padding: 1.3rem;
        }
    }
</style>