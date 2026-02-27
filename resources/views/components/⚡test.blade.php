<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\Computed;

new class extends Component {
    #[Computed]
    public function contacts()
    {
        return Contact::paginate(2);
    }
};
?>

<div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->contacts as $contact)
                <flux:table.row>
                    <flux:table.cell>{{ $contact->name }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>

    </flux:table>
    {{ $this->contacts()->links() }}
</div>
