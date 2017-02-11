<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use GrahamCampbell\Markdown\Facades\Markdown;

class LegalNoticeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $mdfile = public_path('markdown/legal/'.config('kleis.legal_notice').'-'.config('app.locale').'.md');
        if (file_exists($mdfile)){
            list($title, $contents) = explode(PHP_EOL, file_get_contents($mdfile), 2);
            $view->with('enable', true)
                 ->with('title', $title)
                 ->with('contents', Markdown::convertToHtml($contents));
        } else {
            $view->with('enable', false);
        }
    }
}
