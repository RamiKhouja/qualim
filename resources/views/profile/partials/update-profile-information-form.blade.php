<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de votre compte.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="lastname" :value="__('Nom')" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)" autofocus autocomplete="lastname" />
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <div>
            <x-input-label for="firstname" :value="__('Prénom')" />
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value="old('firstname', $user->firstname)" required autofocus autocomplete="firstname" />
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="columns-3">
            <div>
                <x-input-label for="country" :value="__('Pays')" />
                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" autofocus autocomplete="country" />
                <x-input-error class="mt-2" :messages="$errors->get('country')" />
            </div>

            <div>
                <x-input-label for="state" :value="__('État')" />
                <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" autofocus autocomplete="state" />
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
            </div>
            <div>
                <x-input-label for="city" :value="__('Cité')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autofocus autocomplete="city" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Adresse')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" autofocus autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
