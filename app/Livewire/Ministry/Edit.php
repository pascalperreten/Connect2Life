<?php

namespace App\Livewire\Ministry;

use App\Models\Ministry;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $logo;

    public $currentLogoName;

    public $currentLogoPath;

    public $currentLogoUrl;

    #[Validate('required|string|max:255')]
    public $name = '';

    public Ministry $ministry;

    public function mount(Ministry $ministry)
    {
        $this->ministry = $ministry;
        $this->setMinistry();
    }

    public function setMinistry(): void
    {
        $this->name = $this->ministry->name;
        $this->currentLogoName = $this->ministry->logo_name;
        $this->currentLogoPath = $this->ministry->logo_path;
        if ($this->currentLogoPath) {
            $this->currentLogoUrl = Storage::disk('s3')->url($this->ministry->logo_path);
        } else {
            $this->currentLogoUrl = null;
        }
    }

    public function removePhoto()
    {
        $this->logo->delete();

        $this->logo = null;
    }

    public function deleteLogo(): void
    {
        $this->ministry->update([
            'logo_path' => null,
            'logo_name' => null,
        ]);

        Storage::disk('s3')->delete($this->currentLogoPath);

        $this->currentLogoUrl = null;
        $this->currentLogoPath = null;
        Flux::toast(
            heading: __('Logo deleted'),
            text: __('The logo has been deleted successfully.'),
            variant: 'success',
        );
        $this->dispatch('logoUpdated');
    }

    public function update(): void
    {
        $this->authorize('update', $this->ministry);
        $this->validate();
        $path = '';
        if ($this->logo) {
            $path = $this->logo->store('images', 's3');
            $name = $this->logo->getClientOriginalName();

            if ($this->currentLogoPath) {
                Storage::disk('s3')->delete($this->currentLogoPath);
            }
        } else {
            $path = $this->currentLogoPath;
            $name = $this->currentLogoName;
        }

        $this->ministry->update([
            'name' => $this->name,
            'logo_path' => $path,
            'logo_name' => $name,
        ]);

        $this->dispatch('logoUpdated');
        $this->setMinistry();
        $this->logo = null;
        Flux::toast(
            heading: __('Ministry updated'),
            text: __('Your changes have been saved successfully.'),
            variant: 'success',
        );
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->ministry);
        $this->ministry->delete();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.ministry.edit');
    }
}
