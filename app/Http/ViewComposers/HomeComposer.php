<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use GrahamCampbell\Markdown\Facades\Markdown;

class HomeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $mdfile = public_path('markdown/'.config('kleis.announce'));
        if (file_exists($mdfile)){
            $contents = file_get_contents($mdfile);
            $view->with('announce', Markdown::convertToHtml($contents));
        } else {
            $view->with('announce', false);
        }
    }
}
