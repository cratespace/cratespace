<?php

namespace App\Http\Controllers;

use Exception;
use App\Documenters\Article;

class SupportArticleController extends Controller
{
    /**
     * Name of documents collection.
     *
     * @var string
     */
    protected $documents = 'support_articles';

    /**
     * Show support home page with support articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('support.welcome', [
            'articles' => Article::all($this->documents)
        ]);
    }

    /**
     * Show the documentation page.
     *
     * @param string $version
     * @param string $article
     * @return mixed
     */
    public function show($article)
    {
        return view('support.articles.show', [
            'article' => Article::find($this->documents, $article)
        ]);
    }
}
