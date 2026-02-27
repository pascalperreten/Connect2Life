<div class="space-y-6">
    <div class="space-y-4">

        <x-partials.header heading="Details" />
        @can('update', $this->ministry)
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $this->ministry->name }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:separator />
        @endcan

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

                        @if ($currentLogo)
                            <flux:heading>
                                {{ __('Current logo') }}
                            </flux:heading>
                            <flux:card>
                                <div class="flex justify-between items-center">
                                    <div class="h-10">
                                        <img class="max-w-full max-h-full"
                                            src="{{ asset('storage/' . $currentLogoPath) }}">
                                    </div>
                                    <div class="flex justify-end">
                                        <flux:modal.trigger name="delete-logo">
                                            <flux:button icon="trash" variant="ghost" />
                                        </flux:modal.trigger>
                                        <flux:modal name="delete-logo">
                                            <div class="space-y-4">
                                                <flux:heading>{{ __('Delete Logo') }}</flux:heading>
                                                <flux:text>{{ __('Are you sure you want to delete this logo?') }}
                                                </flux:text>
                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:button wire:click="deleteLogo" variant="danger">
                                                        {{ __('Delete') }}</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                    </div>
                                </div>
                            </flux:card>
                        @endif
                        @if ($logo)
                            <flux:heading>{{ __('New logo') }}</flux:heading>
                            <flux:card>
                                <div class="flex justify-between items-center">
                                    <div class="h-10">
                                        <img class="max-w-full max-h-full" src="{{ $logo->temporaryUrl() }}">
                                    </div>
                                    <div class="flex justify-end">
                                        <flux:button icon="x-mark" class="text-red-500" wire:click="removePhoto"
                                            variant="ghost" />
                                    </div>
                                </div>
                            </flux:card>
                            {{-- <flux:file-item :heading="$logo->getClientOriginalName()" :image="$logo->temporaryUrl()"
                                :size="$logo->getSize()">
                                <x-slot name="actions">
                                    <flux:file-item.remove wire:click="removePhoto"
                                        aria-label="{{ 'Remove file: ' . $logo->getClientOriginalName() }}" />
                                </x-slot>
                            </flux:file-item> --}}
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>

                    @can('delete', $this->ministry)
                        <flux:modal.trigger name="delete-ministry">
                            <flux:button variant="danger">{{ __('Delete Ministry') }}</flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-ministry" class="min-w-[22rem] border border-red-500">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg" class="text-red-500">
                                        {{ __('Do you really want to delete your ministry?') }}
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
    <flux:toast />
</div>
