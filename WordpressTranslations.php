<?php

use My\Module\Blogroll\Site\Helper\Translations;

class WordpressTranslations implements Translations  {

    public function get(string $id): string {
        return __($id, 'blogroll');
    }

     public function getPlural(string $id, int $number): string {
        $text = __($id . ($number == 1 ? '_1' : ''), 'blogroll');
        return str_replace('%d', $number, $text);
    }
}