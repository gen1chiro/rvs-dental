<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Dentist;

class DentistDropdown extends Component
{
    public $dentists;
    public function __construct(
        public string $fieldName = 'dentist_id',
        public ?int $selected = null,
        public bool $isRequired = false,
    ){
        $this->dentists = Dentist::orderBy('full_name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.dentist-dropdown', [
            'fieldName' => $this->fieldName,
            'selected'  => $this->selected,
            'isRequired' => $this->isRequired,
            'dentists'  => $this->dentists,
        ]);
    }
}
