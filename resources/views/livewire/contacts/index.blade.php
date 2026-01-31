 <div class="space-y-6">
     <div class="space-y-4">
         <flux:heading size="xl">
             {{ __('Contacts') }}</flux:heading>

         <x-partials.header heading="{{ $event->name . ' - ' . $event->city }}" />
         <div>
             <flux:breadcrumbs>
                 @can('view', $this->ministry)
                     <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                         {{ $this->ministry->name }}
                     </flux:breadcrumbs.item>
                 @endcan

                 <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                     {{ $this->event->name }} - {{ $this->event->city }}
                 </flux:breadcrumbs.item>
                 <flux:breadcrumbs.item>{{ __('Contacts') }}</flux:breadcrumbs.item>
             </flux:breadcrumbs>
         </div>
         <flux:separator />
     </div>

     <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
         @if ($event->contacts->isEmpty())
             <flux:text>{{ __('No contacts have been added to this event yet.') }}</flux:text>
         @else
             <div class="grid md:grid-cols-2 gap-4">
                 <flux:card class="space-y-6">
                     <div class="flex justify-between items-center">
                         <flux:heading size="lg">{{ __('Contacts') }}</flux:heading>
                         <flux:badge color="orange">{{ $this->contacts_number }}</flux:badge>
                     </div>
                     <flux:separator />
                     <div class="flex justify-between items-center">
                         <flux:heading>{{ __('Contacts with decision') }}</flux:heading>
                         <flux:badge color="indigo">{{ $this->contact_with_decision }}</flux:badge>
                     </div>
                     <div class="flex justify-between items-center">
                         <flux:heading>{{ __('Contacts without decision') }}</flux:heading>
                         <flux:badge color="indigo">{{ $this->contact_without_decision }}</flux:badge>
                     </div>

                 </flux:card>
                 <flux:card class="space-y-6">
                     <div class="flex justify-between items-center">
                         <flux:heading size="lg">{{ __('Decisions') }}</flux:heading>
                         <flux:badge color="orange">{{ $this->decisions }}</flux:badge>
                     </div>
                     <flux:separator />
                     <div class="flex justify-between items-center">
                         <flux:heading>{{ __('Decisions with contact details') }}</flux:heading>
                         <flux:badge color="indigo">{{ $this->contact_with_decision }}</flux:badge>
                     </div>
                     <div class="flex justify-between items-center">
                         <flux:heading>{{ __('Decisions without contact details') }}</flux:heading>
                         <flux:badge color="indigo">{{ $this->decisions_without_contact }}</flux:badge>
                     </div>

                 </flux:card>

             </div>
             <div class="p-6 mt-6 shadow-md">
                 <flux:table>
                     <flux:table.columns>
                         <flux:table.column>Name</flux:table.column>
                         <flux:table.column>{{ __('Church') }}</flux:table.column>
                         <flux:table.column>{{ __('Contacted') }}</flux:table.column>
                         <flux:table.column>{{ __('Met') }}</flux:table.column>
                         <flux:table.column></flux:table.column>
                     </flux:table.columns>

                     <flux:table.rows>
                         @foreach ($this->contacts as $contact)
                             <flux:table.row :key="$contact->id">
                                 <flux:table.cell>{{ $contact->name }}</flux:table.cell>
                                 <flux:table.cell>
                                     @if ($contact->church)
                                         <div class="flex items-center gap-4">
                                             <flux:dropdown align="end">
                                                 <flux:button icon:trailing="user"></flux:button>
                                                 <flux:menu keep-open>
                                                     @if ($contact->church->followUpContact)
                                                         @if ($contact->church->followUpContact->phone)
                                                             <flux:menu.item x-data="{ copied: false }"
                                                                 class="flex justify-between gap-4 mt-3 mb-4">
                                                                 <flux:text>
                                                                     {{ $contact->church->followUpContact->phone }}
                                                                 </flux:text>
                                                                 <span class="flex gap-4">
                                                                     <flux:link
                                                                         href="tel:{{ $contact->church->followUpContact->phone }}">
                                                                         <flux:icon.phone />
                                                                     </flux:link>
                                                                     <flux:separator vertical />
                                                                     <flux:icon.clipboard
                                                                         class="cursor-pointer justify-self-end"
                                                                         x-show="!copied"
                                                                         x-on:click="$clipboard('{{ $contact->church->followUpContact->phone }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                                                     <flux:icon.clipboard-document-check
                                                                         x-show="copied" />
                                                                 </span>

                                                             </flux:menu.item>
                                                         @endif

                                                         <flux:separator />
                                                         <flux:menu.item x-data="{ copied: false }"
                                                             class="flex gap-4 mt-4 mb-3">
                                                             <flux:text>{{ $contact->church->followUpContact->email }}
                                                             </flux:text>
                                                             <span class="flex gap-4">
                                                                 <flux:link
                                                                     href="mailto:{{ $contact->church->followUpContact->email }}">
                                                                     <flux:icon.envelope />
                                                                 </flux:link>
                                                                 <flux:separator vertical />
                                                                 <flux:icon.clipboard class="cursor-pointer self-end"
                                                                     x-show="!copied"
                                                                     x-on:click="$clipboard('{{ $contact->church->followUpContact->email }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                                                 <flux:icon.clipboard-document-check x-show="copied" />
                                                             </span>
                                                         </flux:menu.item>
                                                     @endif
                                                 </flux:menu>
                                             </flux:dropdown>
                                             <flux:link
                                                 href="{{ route('churches.show', [$this->ministry, $event, $contact->church]) }}"
                                                 wire:navigate>
                                                 {{ $contact->church->name }}</flux:link>
                                         </div>
                                     @else
                                         @if ($contact->assigned === true && !$contact->church_id)
                                             test
                                         @endif
                                         <flux:badge size="sm" color="red">{{ __('pending') }}</flux:badge>
                                     @endif
                                 </flux:table.cell>

                                 <flux:table.cell>
                                     @if ($contact->invalid_contact_details)
                                         <flux:badge color="red">{{ __('invalid') }}</flux:badge>
                                     @elseif ($contact->contacted_date)
                                         <flux:badge color="green">{{ $this->setDate($contact->contacted_date) }}
                                         </flux:badge>
                                     @else
                                         <flux:badge color="red">{{ __('pending') }}</flux:badge>
                                     @endif
                                 </flux:table.cell>
                                 <flux:table.cell>

                                     @if (!$contact->invalid_contact_details)
                                         @if ($contact->not_interested)
                                             <flux:badge color="red">{{ __('no interest') }}</flux:badge>
                                         @elseif($contact->meeting_date)
                                             <flux:badge color="{{ $contact->met ? 'green' : 'orange' }}">
                                                 {{ $this->setDate($contact->meeting_date) }}
                                             </flux:badge>
                                         @else
                                             <flux:badge color="red">{{ __('pending') }}</flux:badge>
                                         @endif
                                     @endif

                                 </flux:table.cell>
                                 <flux:table.cell class="text-end" inset="top-bottom">
                                     <flux:button icon:trailing="arrow-up-right"
                                         href="{{ route('contacts.show', [$this->ministry, $event, $contact]) }}"
                                         wire:navigate size="sm">{{ __('Show') }}
                                     </flux:button>
                                 </flux:table.cell>
                             </flux:table.row>
                         @endforeach
                     </flux:table.rows>
                 </flux:table>
             </div>
         @endif
     </livewire:event-nav>
 </div>
