<?php

namespace App\Tools;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Censurator
{

    const WRONG_WORDS = ['patate', 'irwin'];
    public function purify( string $word):string
    {
        $newWord = str_ireplace(self::WRONG_WORDS, '*****', $word);
        return $newWord;

    }
    //Fonctionne aussi
//    public function purify( string $word):string
//    {
//        $wrongWords = ['patate', 'irwin'];
//        $goodWords = ['*****'];
//        $newWord = str_ireplace($wrongWords, $goodWords, $word);
//
//        return $newWord;
//
//    }


}