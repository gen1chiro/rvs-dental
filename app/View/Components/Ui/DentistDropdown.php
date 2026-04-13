<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Dentist;

class DentistDropdown extends Component
{
    public $dentists;
    public function __construct(
        public string $fieldName = "dentist_id",
        public ?int $selected = null,
        public bool $isRequired = false,
    ){
        $this->dentists = Dentist::select(['dentist_id', 'first_name', 'last_name'])->orderBy('last_name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dentist-dropdown');
    }
}
