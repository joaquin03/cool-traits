<?php

namespace App\Traits;



Trait SlugModelTrait {


    public function setSlug($slug)
    {
        $this->slug = $slug;

        $lastSlug = $this->withTrashed()
                    ->whereRaw("slug RLIKE '^{$this->slug}(-[0-9]*)?$'")
                    ->latest('id')
                    ->pluck('slug');

        if ($lastSlug) {
            $pieces = explode('-', $lastSlug);
            $number = intval(end($pieces));

            $this->slug .= '-'.($number+1);
        }

        $this->save();
    }
} 