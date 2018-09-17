<?php

namespace CampaigningBureau\LaravelPageMix\Classes;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class PageMix
{

    /**
     * @var Collection
     */
    private $files;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var Collection
     */
    private $ignored_files;


    public function __construct($filesystem)
    {
        $this->filesystem = $filesystem;

        $this->ignored_files = new Collection(Config::get('page-mix.ignore'));

        $this->parseMixManifest();
    }

    public function getScript()
    {
        $script_path = $this->mapRouteNameToScript();

        return mix($script_path);
    }

    private function mapRouteNameToScript()
    {
        $current_route = Route::current();
        $name = $current_route->getName();

        if ($this->files->has($name)) {
            return $this->files->get($name);
        } else {
            return Config::get('page-mix.default');
        }
    }

    private function parseMixManifest()
    {
        $mix_manifest = public_path('mix-manifest.json');

        if ($this->filesystem->exists($mix_manifest)) {
            $json = $this->filesystem->get($mix_manifest);
            $mix_data = json_decode($json);

            $this->files = collect($mix_data)
                ->flip()
                ->filter(function ($file_path)
                {
                    return !$this->ignored_files->contains($file_path);
                })
                ->filter(function ($file_path)
                {
                    return substr($file_path, -3) === '.js';
                })
                ->mapWithKeys(function ($file_path)
                {
                    return [
                        basename($file_path, '.js') => $file_path,
                    ];
                });
        }
    }
}
