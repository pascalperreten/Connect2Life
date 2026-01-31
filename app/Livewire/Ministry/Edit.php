<?php

namespace App\Livewire\Ministry;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\User;
use Livewire\Attributes\Validate;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class Edit extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $logo;
    public $currentLogoName;
    public $currentLogoPath;
    public $currentLogo;

    public function removePhoto()
    {
        $this->logo->delete();

        $this->logo = null;
    }

    public function deleteLogo() {
        $this->ministry->update([
            'logo_path' => null,
            'logo_name' => null,
        ]);

        Storage::disk('public')->delete($this->currentLogoPath);

        $this->currentLogo = null;
        $this->setMinistry();
        $this->modal('delete-logo')->close();

        Flux::toast(
            heading: 'Logo gelöscht',
            text: 'Deine Änderungen wurden erfolgreich gespeichert.',
            variant: 'success',
        );
    }

    #[Validate('required|string|max:255')]
    public $name = '';

    public Ministry $ministry;

    public function mount(Ministry $ministry) {
        $this->ministry = $ministry;
        $this->setMinistry();
    }

    public function setMinistry() {
        $this->name = $this->ministry->name;
        $this->currentLogoName = $this->ministry->logo_name;
        $this->currentLogoPath = $this->ministry->logo_path;
        if($this->currentLogoPath) {
            $this->currentLogo = asset('storage/' . $this->ministry->logo_path);
        }
        
    }

    public function update() {
        //$this->authorize('update', $this->ministry);
        $this->validate();
        $path = '';
        if($this->logo) {
            $path = $this->logo->store('images', 'public');
        }
        
        $this->ministry->update([
            'name' => $this->name,
            'logo_path' => $path,
            'logo_name' => $this->logo->getClientOriginalName(),
        ]);
        Flux::toast(
            heading: 'Ministry geändert',
            text: 'Deine Änderungen wurden erfolgreich gespeichert.',
            variant: 'success',
        );
        $this->setMinistry();
        $this->logo = null;
    }

    public function delete() {
        $this->authorize('delete', $this->ministry);
        $this->ministry->delete();
    }

    public function render()
    {
        return view('livewire.ministry.edit');
    }
}
