<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Mail\Markdown;

class HomeComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $announce = false;
        if (config('kleis.announce')) {
            $mdfile = public_path('markdown/'.config('kleis.announce'));
            if (file_exists($mdfile)) {
                $text = file_get_contents($mdfile);
                $announce = Markdown::parse($text)->toHtml();
            }
        }
        $view->with('announce', $announce);
    }
}
