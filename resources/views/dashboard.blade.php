<x-layouts.app :title="__('Dashboard')">
    <flux:heading class="border-b border-zinc-200 py-4" size="xl">{{ auth()->user()->ministry->name }}</flux:heading>
    <div class="flex items-center justify-between mt-6 mb-4">

        <flux:heading size="lg">Members</flux:heading>
        <div>
            <flux:modal.trigger name="invite-member">
                <flux:button>Invite Member</flux:button>
            </flux:modal.trigger>

            <flux:modal name="invite-member" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Invite Member</flux:heading>
                        <flux:text class="mt-2">Please provide the following data</flux:text>
                    </div>
                    <flux:field>
                        <flux:label>First Name</flux:label>
                        <flux:input wire:model="first_name" type="text" />
                        <flux:error name="first_name" />
                    </flux:field>
                    <flux:field>
                        <flux:label>Last Name</flux:label>
                        <flux:input wire:model="last_name" type="text" />
                        <flux:error name="last_name" />
                    </flux:field>
                    <flux:field>
                        <flux:label>Email</flux:label>
                        <flux:input wire:model="email" type="email" />
                        <flux:error name="email" />
                    </flux:field>

                    <div class="flex">
                        <flux:spacer />
                        <flux:button type="button" wire:click="sendInvitation" variant="primary">Invite new Member
                        </flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
        <div>
            @if ($event->members->isEmpty())
                <flux:text>No members have been added to this event yet.</flux:text>
            @else
                <div class="p-6 shadow-md">
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Name</flux:table.column>
                            <flux:table.column>Role</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach ($event->members as $member)
                                <flux:table.row :key="$member->id">
                                    <flux:table.cell>{{ $member->name }}</flux:table.cell>
                                    <flux:table.cell>
                                        {{ ucfirst(str_replace('_', ' ', $member->pivot->role)) }}
                                    </flux:table.cell>
                                    <flux:table.cell class="text-end" inset="top-bottom">
                                        <flux:button icon:trailing="arrow-up-right"
                                            href="{{ route('churches.show', ['event' => $event, 'church' => $church]) }}"
                                            wire:navigate size="sm">edit
                                        </flux:button>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </div>
            @endif

        </div>

    </div>

    <div>
        <flux:text class="mt-8">Hallo {{ auth()->user()->name }}! Was möchtest du machen?</flux:text>
        <flux:button href="https://fluxui.dev/components/button" wire:navigate variant="ghost" class="mt-4">Neue Event
            erstellen
        </flux:button><br>
        <flux:button variant="ghost">Neue Kirche hinzufügen</flux:button><br>
        <flux:button variant="ghost">Neue Contacts anschauen</flux:button>
    </div>
</x-layouts.app>
