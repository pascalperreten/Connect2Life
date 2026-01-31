<?php

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

new class extends Component {
    public $locale;

    public function mount()
    {
        $this->locale = Cookie::get('locale', config('app.locale'));
        App::setLocale($this->locale);
    }

    public function switchLanguage($lang)
    {
        App::setLocale($lang);
        //session()->put(['locale' => $lang]);

        Cookie::queue(Cookie::forever('locale', $lang));
        return $this->redirect(url()->previous(), navigate: true);
    }

    public function checkLocale()
    {
        dd(app()->getLocale());
    }
};
?>

<div>
    <flux:radio.group wire:model="locale" variant="segmented">
        <flux:radio wire:click="switchLanguage('de')" value="de" label="DE" />
        <flux:radio wire:click="switchLanguage('en')" value="en" label="EN" />
    </flux:radio.group>

</div>
