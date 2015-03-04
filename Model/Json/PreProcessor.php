<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Translation\Model\Json;

use Magento\Framework\View\Asset\PreProcessorInterface;
use Magento\Translation\Model\Js\Config;
use Magento\Translation\Model\Js\DataProviderInterface;
use Magento\Framework\View\Asset\PreProcessor\Chain;

/**
 * PreProcessor responsible for providing js translation dictionary
 */
class PreProcessor implements PreProcessorInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * @param Config $config
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        Config $config,
        DataProviderInterface $dataProvider
    ) {
        $this->config = $config;
        $this->dataProvider = $dataProvider;
    }

    /**
     * Transform content and/or content type for the specified preprocessing chain object
     *
     * @param Chain $chain
     * @return void
     */
    public function process(Chain $chain)
    {
        if ($this->isDictionaryPath($chain->getTargetAssetPath())) {
            $chain->setContent(json_encode($this->dataProvider->getData()));
            $chain->setContentType('json');
        }
    }

    /**
     * Is provided path the path to translation dictionary
     *
     * @param string $path
     * @return bool
     */
    protected function isDictionaryPath($path)
    {
        return (strpos($path, Config::DICTIONARY_FILE_NAME) !== false);
    }
}
