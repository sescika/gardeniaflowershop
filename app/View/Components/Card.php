<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $imgUrl, $imgAlt, $title, $description, $price, $largeSize, $mediumSize;
    public function __construct($imgUrl, $imgAlt, $title, $description, $price, $largeSize = 4, $mediumSize = 6)
    {
        $this->imgUrl = $imgUrl;
        $this->imgAlt = $imgAlt;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->largeSize = $largeSize;
        $this->mediumSize = $mediumSize;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
