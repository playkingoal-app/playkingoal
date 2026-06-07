<!-- EDIT PROFILE MODAL -->
<div wire:ignore.self
     class="modal fade"
     id="updateProfileModal"
     data-bs-backdrop="static"
     tabindex="-1"
     role="dialog"
     aria-labelledby="updateModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0 pb-0">

                <h5 class="modal-title fw-bold" id="updateModalLabel">

                    <i class="fa-solid fa-user-pen me-2"
                       style="color:#ff6600;"></i>

                    {{ __('profile.edit_profile') }}

                </h5>

                <button wire:click.prevent="cancel()"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>

            {{-- BODY --}}
            <div class="modal-body pt-4">

           

                    <input type="hidden" wire:model="selected_id">

                    {{-- NAME --}}
                    <div class="mb-4">

                        <label for="name"
                               class="form-label fw-semibold">

                            {{ __('profile.full_name') }}

                        </label>

                        <input type="text"
                               id="name"
                               wire:model.defer="name"
                               value="{{ Auth::user()->name }}"
                               class="form-control rounded-pill px-3 py-2"
                               placeholder="{{ __('profile.full_name') }}">

                        @error('name')
                            <span class="text-danger small">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-4">

                        <label for="email"
                               class="form-label fw-semibold">

                            {{ __('profile.email') }}

                        </label>

                        <input type="email"
                               id="email"
                               wire:model.defer="email"
                               value="{{ Auth::user()->email }}"
                               class="form-control rounded-pill px-3 py-2"
                               placeholder="{{ __('profile.email') }}">

                        @error('email')
                            <span class="text-danger small">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>
{{-- TELEFONO --}}
<div class="row">

    <div class="col-md-5 mb-4">

        <label for="phone_country_code_id" class="form-label fw-semibold">
            {{ __('profile.phone_country') }}
        </label>

        <select id="phone_country_code_id"
            wire:model.defer="phone_country_code_id"
            class="form-select rounded-pill px-3 py-2">

            <option value="">
                {{ __('profile.select_country_code') }}
            </option>

            @foreach($phoneCountryCodes as $countryCode)
                <option value="{{ $countryCode->id }}">
                    {{ $countryCode->country }} ({{ $countryCode->dial_code }})
                </option>
            @endforeach

        </select>

        @error('phone_country_code_id')
            <span class="text-danger small">{{ $message }}</span>
        @enderror

    </div>

    <div class="col-md-7 mb-4">

        <label for="phone" class="form-label fw-semibold">
            {{ __('profile.phone') }}
        </label>

        <input type="text"
            id="phone"
            wire:model.defer="phone"
            class="form-control rounded-pill px-3 py-2"
            placeholder="3001234567">

        @error('phone')
            <span class="text-danger small">{{ $message }}</span>
        @enderror

    </div>

</div>
                    {{-- INFO --}}
                    <div class="alert border-0 rounded-4 d-flex align-items-center gap-2"
                         style="background:#fff4ef; color:#ff6600;">

                        <i class="fa-solid fa-circle-info"></i>

                        <small class="mb-0">
                            {{ __('profile.country_cannot_be_changed') }}
                        </small>

                    </div>

               

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 pt-0">

                <button type="button"
                        wire:click.prevent="cancel()"
                        class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">

                    {{ __('profile.cancel') }}

                </button>
<button type="button"
        class="profile-button primary"
        wire:click.prevent="updateProfile">

    <i class="fa-solid fa-floppy-disk me-1"></i>
    {{ __('profile.save_changes') }}

</button>

            </div>

        </div>

    </div>

</div>