<div class="px-10">
    <form wire:submit.prevent="update" x-data="
            { 
              'errors': {{ json_encode(array_keys($errors->getMessages())) }},
              focusField(input){
                  fieldError = Array.from(document.getElementsByName(input));
                  if(fieldError.length > 0){
                    fieldError[0].focus({preventScroll:false});
                  }
              },
            }
            " x-init="() => { $watch('errors', value => focusField(value[0])) }">
        @csrf

        <div class="mt-4">

            <div class="mt-4">
                <x-jet-label for="current_password" value="{{ __('Password Saat Ini') }}" />
                <x-jet-input wire:model="current_password" id="current_password" class="block mt-1 w-full" type="password" name="current_password" />
                @error('current_password') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password Baru') }}" />
                <x-jet-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" />
                @error('password') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Konfirmasi Password Baru') }}" />
                <x-jet-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
            </div>            
            
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Update') }}
            </x-jet-button>
        </div>
    </form>
</div>