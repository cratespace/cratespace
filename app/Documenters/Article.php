<?php

namespace App\Documenters;

class Article extends Documents
{
    /**
     * Get all requested article collection.
     *
     * @param  string $articles
     * @return array
     */
    public static function all($articles)
    {
        return static::get($articles)->all();
    }

    /**
     * Find given article from given articles collection.
     *
     * @param  string $articles
     * @param  string $article
     * @return \Spatie\Sheets\Sheet
     */
    public static function find($articles, $article)
    {
        return static::get($articles)->get($article);
    }
}
