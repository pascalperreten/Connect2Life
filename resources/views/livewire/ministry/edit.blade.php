<div class="space-y-4">
    <div class="space-y-4">
        @if ($this->ministry->logo_path)
            <div class="flex justify-center">
                <div class="w-50">
                    <img class="max-h-full max-w-full" src="{{ asset('storage/' . $this->ministry->logo_path) }}">
                </div>
            </div>
        @else
            <flux:heading size="xl">{{ $this->ministry->name }}</flux:heading>
        @endif
        <x-partials.header heading="Details" />
    </div>
    <livewire:ministry-nav :ministry="$this->ministry">
        <flux:card>
            <form wire:submit="update" class="space-y-6">
                <flux:field>
                    <flux:label>Ministry Name</flux:label>
                    <flux:input wire:model="name" type="text" />
                    <flux:error name="name" />
                </flux:field>

                <div>
                    <flux:file-upload wire:model="logo" label="Logo">
                        <flux:file-upload.dropzone with-progress
                            heading="{{ __('Drop files here or click to browse') }}"
                            text="{{ __('JPG, PNG up to 2MB') }}" />
                    </flux:file-upload>

                    <div class="mt-3 flex flex-col gap-2">
                        @if ($logo)
                            <flux:file-item :heading="$logo->getClientOriginalName()" :image="$logo->temporaryUrl()"
                                :size="$logo->getSize()">
                                <x-slot name="actions">
                                    <flux:file-item.remove wire:click="removePhoto"
                                        aria-label="{{ 'Remove file: ' . $logo->getClientOriginalName() }}" />
                                </x-slot>
                            </flux:file-item>
                        @endif
                        @if ($currentLogo)
                            <flux:card>
                                <div class="grid sm:grid-cols-3 gap-4 grid-cols-2 items-center">
                                    <flux:heading class="col-span-2 text-center sm:text-left sm:col-span-1">
                                        {{ __('current logo') }}
                                    </flux:heading>
                                    <flux:text class="text-center">{{ $this->currentLogoName }}</flux:text>
                                    <div class="flex justify-end">
                                        <flux:modal.trigger name="delete-logo">
                                            <flux:icon.trash class="cursor-pointer text-red-500" />
                                        </flux:modal.trigger>
                                        <flux:modal name="delete-logo">
                                            <div class="space-y-4">
                                                <flux:heading>{{ __('Delete Logo') }}</flux:heading>
                                                <flux:text>{{ __('Are you sure you want to delete this logo?') }}
                                                </flux:text>
                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:button class="cursor-pointer" wire:click="deleteLogo"
                                                        variant="danger">{{ __('Delete') }}</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                    </div>
                                </div>
                                <flux:separator class="mt-4" />
                                <div class="flex p-4 justify-center max-w-md m-auto">
                                    <img class="max-w-full max-h-full"
                                        src="{{ asset('storage/' . $currentLogoPath) }}">
                                </div>
                            </flux:card>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>

                    @can('delete', $this->ministry)
                        <flux:modal.trigger name="delete-ministry">
                            <flux:button variant="danger">{{ __('Delete') }}</flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-ministry" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">{{ __('Do you want to delete your ministry?') }}
                                    </flux:heading>
                                    <flux:text class="mt-2">
                                        {{ __('All data, all events, churches, and members will be deleted. This cannot be undone.') }}
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="button" wire:click="delete" variant="danger">
                                        {{ __('Delete Ministry') }}
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    @endcan
                </div>
            </form>
        </flux:card>
    </livewire:ministry-nav>
</div>
