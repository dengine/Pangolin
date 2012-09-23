<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Templating;

class TwigTemplater implements ITemplater
{

    private $_templater;

    public function __construct($templatesDir, $cacheDir)
    {
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($templatesDir);
        $this->_templater = new \Twig_Environment($loader, array(
            'cache' => $cacheDir
        ));
    }

    public function render(array $parameters, $templateName)
    {
        return $this->_templater->render("{$templateName}.tpl", $parameters);
    }

}