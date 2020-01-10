<?php

function detectContactLanguage($contact)
{
    if (preg_match('/[اأإء-ي]/ui', $contact)) {
        return 'ar';
    }
    return 'en';
}
