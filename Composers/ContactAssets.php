<?php namespace Modules\Contact\Composers;

use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Modules\Core\Foundation\Asset\Types\AssetTypeFactory;

class ContactAssets
{
    /**
     * @var AssetPipeline
     */
    private $assetPipeline;
    /**
     * @var AssetTypeFactory
     */
    private $assetFactory;
    /**
     * @var AssetManager
     */
    private $assetManager;

    public function __construct(AssetPipeline $assetPipeline, AssetTypeFactory $assetFactory, AssetManager $assetManager)
    {
        $this->assetPipeline = $assetPipeline;
        $this->assetFactory = $assetFactory;
        $this->assetManager = $assetManager;
    }

    public function compose()
    {
        $this->addAssets();
        $this->requireAssets();
    }

    private function addAssets()
    {
        foreach (config('asgard.contact.assets.contact-partial-assets', []) as $assetName => $path) {
            $path = $this->assetFactory->make($path)->url();
            $this->assetManager->addAsset($assetName, $path);
        }
    }

    private function requireAssets()
    {
        $css = config('asgard.contact.assets.contact-partial-required-assets.css');
        $js  = config('asgard.contact.assets.contact-partial-required-assets.js');

        if (!empty($css)) {
            $this->assetPipeline->requireCss($css);
        }

        if (!empty($js)) {
            $this->assetPipeline->requireJs($js);
        }
    }
}