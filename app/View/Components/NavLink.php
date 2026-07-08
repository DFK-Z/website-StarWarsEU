<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    public function __construct(
        public string $href,
        public ?string $active = null
    ) {}

    public function isActive(): bool
    {
        if ($this->active) {
            return request()->routeIs($this->active);
        }
        return request()->url() === $this->href;
    }

    public function render()
    {
        return view('components.nav-link');
    }
}
