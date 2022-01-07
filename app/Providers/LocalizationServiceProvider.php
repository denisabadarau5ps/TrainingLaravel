<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * The path to the current lang files.
     *
     * @var string
     */
    protected $langPath;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = App::getLocale();
        $this->langPath = resource_path('lang/' . $locale);

        //Save all translations attribute to Cache forever
        Cache::rememberForever('translations', function () {
            return collect(File::allFiles($this->langPath))->flatMap(function ($file) {
                return [
                    $translation = $file->getBasename('.php') => trans($translation),
                ];
            })->toJson();
        });
    }
}
