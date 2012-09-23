<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Templating;

class JsonTemplater implements ITemplater
{
    public function render(array $parameters, $templateName)
    {
        return (string) \Pangolin\Data\Json::FromArray($parameters);
    }
}