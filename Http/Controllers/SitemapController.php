<?php

namespace Modules\Contact\Http\Controllers;

use Modules\Sitemap\Http\Controllers\BaseSitemapController;

class SitemapController extends BaseSitemapController
{
    public function __construct()
    {
        parent::__construct();
        $this->sitemap->setCache('laravel.contact.sitemap', $this->sitemapCachePeriod);
    }

    public function index()
    {
        $locales = \LaravelLocalization::getSupportedLocales();
        $translations = [];
        foreach ($locales as $locale => $localeValues) {
            if ($locale == \LaravelLocalization::getCurrentLocale()) continue;
            $translations[] = ['language'=>$locale, 'url'=>getURLFromRouteNameTranslated($locale, 'contact::routes.contact')];
        }
        $this->sitemap->add(route('contact'), \Carbon\Carbon::now(), '0.8', 'weekly', [], null, $translations);
        return $this->sitemap->render('xml');
    }
}
