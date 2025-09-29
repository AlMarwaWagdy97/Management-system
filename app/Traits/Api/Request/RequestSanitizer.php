<?php


namespace App\Traits\Api\Request;


trait RequestSanitizer
{

    public function getSanitized(): array
    {
        $files = array_keys($this->allFiles());
        return collect($this->validated())->except($files)->toArray();
    }
}