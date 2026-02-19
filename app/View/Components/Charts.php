<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Event;
use App\Models\Contact;

class Charts extends Component
{
    /**
     * Create a new component instance.
     */
    public Event $event;
    public $labels = ['Decisions with Contact Info', 'Decisions without Contact Info'];
    public $data = [];
    public function __construct(Event $event)
    {
        $this->event = $event;
        $decisions = Event::find($this->event->id)->decisions;
        $decisionsWithContactInfo = Contact::where('event_id', $this->event->id)->where('decision', true)->count();
        $decisionsWithoutContactInfo = $decisions - $decisionsWithContactInfo;
    }

    /** 
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts');
    }
}
