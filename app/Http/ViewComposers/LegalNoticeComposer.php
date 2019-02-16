<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Mail\Markdown;

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
        $enable = false;
        $title = '';
        $contents = '';
        if (config('kleis.legal_notice')) {
            $mdfile = public_path('markdown/legal/'.config('kleis.legal_notice').'-'.config('app.locale').'.md');
            if (file_exists($mdfile)){
                list($title, $text) = explode(PHP_EOL, file_get_contents($mdfile), 2);
                $enable = true;
                $contents = Markdown::parse($text)->toHtml();
            }
        }
        $view->with('enable', $enable)
             ->with('title', $title)
             ->with('contents', $contents);
    }
}
