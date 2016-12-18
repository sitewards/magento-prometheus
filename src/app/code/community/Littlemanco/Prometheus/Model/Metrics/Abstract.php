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
class Littlemanco_Prometheus_Model_Metrics_Abstract
{
    const XML_PATH_TEMPLATE = 'metrics/%s/%s';

    private $aAllowedTypes = [
        'counter',
        'gauge'
    ];

    /**
     * @var string
     */
    protected $sMetricName;

    /**
     * @var string
     */
    private $sMetricType;

    /**
     * @var string
     */
    private $sMetricHelp;

    public function __construct()
    {
        if (!$this->sMetricName) {
            throw new Littlemanco_Prometheus_Exception_InvalidMetric('Metric does not have a name, cannot be used');
        }

        /** @var Mage_Core_Model_Config_Element $oTypeNode */
        $oTypeNode = Mage::getConfig()->getNode(sprintf(self::XML_PATH_TEMPLATE, $this->sMetricName, 'type'));

        if ($oTypeNode) {
            $oTypeString = $oTypeNode->__toString();

            if (!$this->isValidType($oTypeString)) {
                throw new Littlemanco_Prometheus_Exception_InvalidMetric('Metric is not of supported type, cannot be used');
            }

            $this->sMetricType = $oTypeString;
        }

        /** @var Mage_Core_Model_Config_Element $oHelpNode */
        $oHelpNode = Mage::getConfig()->getNode(sprintf(self::XML_PATH_TEMPLATE, $this->sMetricName, 'help'));

        if ($oHelpNode) {
            $this->sMetricHelp = $oHelpNode->__toString();
        }
    }

    /**
     * Checks to see whether the metric type is supported.
     *
     * @param string $sType
     * @return bool
     */
    private function isValidType($sType)
    {
        if (!in_array($sType, $this->aAllowedTypes)) {
            return false;
        }

        return true;
    }
}