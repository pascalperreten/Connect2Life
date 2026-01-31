<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use App\Models\Event;
use App\Models\Language;
use App\Models\LanguageTranslation;
use Illuminate\Validation\Rule;
use Flux\Flux;
use Illuminate\Database\Query\Builder;
use Livewire\Form;
use DeepL\Translator;

class LanguageForm extends Form
{

    public Event $event;
    public ?Language $language;

    public $name = '';
    public $languages;
    public $edit = [];

    protected function rules() {
        $unique = Rule::unique('language_translations')->where('event_id', $this->event->id);

        if (isset($this->language)) {
            $unique->ignore($this->language->id);
        }
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $unique,
            ]
            ];
    }

    public function editItem($id) {
        $this->edit = [
            'language' => $id,
        ];
    }

    public function setLanguages($event) {
        $this->languages = Language::where('event_id', $event->id)->with('translation')->get();
        $this->languages = Language::where('languages.event_id', $event->id)
            ->join('language_translations', function($join) {
                $join->on('languages.id', '=', 'language_translations.language_id')
                    ->where('language_translations.locale', app()->getLocale());
            })
            ->orderBy('language_translations.name')
            ->select('languages.*')
            ->with('translation')
            ->get();
    }

    public function addLanguage() {
        $this->validateOnly('name');

        $translator = new \DeepL\DeeplClient(env('DEEPL_KEY'));
        $german_name = $translator->translateText($this->name, null, 'DE');
        $english_name = $translator->translateText($this->name, null, 'EN-US');
        
        $newLanguage = Language::create([
            'event_id' => $this->event->id,
        ]);
        
        $newLanguage->translations()->createMany([
            ['locale' => 'de', 'name' => $german_name, 'event_id' => $this->event->id],
            ['locale' => 'en', 'name' => $english_name, 'event_id' => $this->event->id],
        ]);
        Flux::toast(
            heading: 'Language added',
            text: 'The Language has been added successfully.',
            variant: 'success',
        );

        $this->setLanguages($this->event);
        $this->reset('name');
        return $newLanguage;
    }

    public function updateLanguage($id) {
        $this->validateOnly('name');
        $language = LanguageTranslation::where('language_id', $id)->where('locale', app()->getLocale())->first();
        $language->update([
            'name' => $this->name,
        ]);
        Flux::toast(
            heading: 'Language updated',
            text: 'The language has been updated successfully.',
            variant: 'success',
        );
        $this->edit = [];
    }
    public function deleteLanguage($id) {
        Language::where('id', $id)->delete();
        Flux::modals()->close();
        Flux::toast(
            heading: 'Language deleted',
            text: 'The language has been deleted successfully.',
            variant: 'success',
        );
        $this->edit = [];
    }
}
