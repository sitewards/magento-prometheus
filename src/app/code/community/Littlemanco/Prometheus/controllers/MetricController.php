<?php
/**
 * Copyright 2016 littleman.co
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category Littlemanco
 * @package  Littlemanco_Prometheus
 * @license  apache-2.0
 */

use Prometheus\RenderTextFormat;

class Littlemanco_Prometheus_MetricController extends Mage_Core_Controller_Front_Action
{
    /**
     * Renders the Magento metrics
     *
     * @todo: Render the text or HTML version depending on the request headers
     */
    public function indexAction()
    {
        /** @var Littlemanco_Prometheus_Model_Resource_Metrics $oResourceModel */
        $oResourceModel = Mage::getResourceSingleton('littlemanco_prometheus/metrics');

        $oRenderer = new RenderTextFormat();
        $sContent = $oRenderer->render($oResourceModel->getMetricFamilySamples());
        $this->getResponse()->setBody($sContent);
        $this->getResponse()->setHeader('Content-type', RenderTextFormat::MIME_TYPE);
    }
}