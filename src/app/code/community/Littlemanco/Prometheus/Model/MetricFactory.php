<?php
/**
 * Copyright 2017 littleman.co
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

/**
 * Responsible for fetching constructed metrics from the Magento registry so their state can be modified.
 */
class Littlemanco_Prometheus_Model_MetricFactory
{
    const S_REGISTRY_PREFIX = 'littlemanco_prometheus_metric_';

    /**
     * Fetches the counter instance of a given metric, constructing it if it does not exist
     *
     * @param string $sName The name of the metric in the Prometheus format
     * @param array  $aArgs Arguments to be passed to the model constructor. Expects an array of the form
     *                      [
     *                          'help'   => 'This is help text to describe a metric',
     *                          'labels' => [
     *                               'label_title_a'
     *                          ]
     *                      ]
     *
     * @return Littlemanco_Prometheus_Model_Metrics_Counter
     */
    public function getCounter($sName, $aArgs = [])
    {
        return $this->_getInstance(Littlemanco_Prometheus_Model_Metrics_Abstract::S_TYPE_COUNTER, $sName, $aArgs);
    }

    /**
     * Fetches the gauge instance of a given metric, constructing if it does not exist
     *
     * @param string $sName The name of the metric in the Prometheus format
     * @param array  $aArgs Arguments to be passed to the model constructor. Expects an array of the form
     *                      [
     *                          'help'   => 'This is help text to describe a metric',
     *                          'labels' => [
     *                               'label_title_a'
     *                          ]
     *                      ]
     *
     * @return Littlemanco_Prometheus_Model_Metrics_Gauge
     */
    public function getGauge($sName, $aArgs = [])
    {
        return $this->_getInstance(Littlemanco_Prometheus_Model_Metrics_Abstract::S_TYPE_GAUGE, $sName, $aArgs);
    }

    /**
     * Fetches the instance responsible for modifying a metric. Constructs the model and sets it into the registry if it
     * does not exist
     *
     * @param string $sType           The type of metric. Supported types are defined in the switch statement
     * @param string $sName           The name of the metric in the Prometheus format
     * @param array  $aAdditionalArgs Arguments to be passed to the model constructor. Expects an array of the form
     *                                [
     *                                    'help'   => 'This is help text to describe a metric',
     *                                    'labels' => [
     *                                       'label_title_a'
     *                                    ]
     *                                ]
     *
     * @return Littlemanco_Prometheus_Model_Metrics_Abstract
     * @throws Littlemanco_Prometheus_Exception_InvalidMetricType if the metric type is not one that can be used
     */
    private function _getInstance($sType, $sName, array $aAdditionalArgs = [])
    {
        $sRegistryKey = self::S_REGISTRY_PREFIX . $sName;


        /** @var Littlemanco_Prometheus_Model_Metrics_Abstract $oObject */
        $oObject = Mage::registry($sRegistryKey);

        if ($oObject) {
            return $oObject;
        }

        // The abstract requires the name as the first argument, the help as the second argument and labels as the
        // third argument. So, we construct that format (handled by the Magento factory):
        $aArgs = array_merge(['metric_name' => $sName], $aAdditionalArgs);

        // If the object does not exist, construct it and persist it
        switch ($sType) {
            case Littlemanco_Prometheus_Model_Metrics_Abstract::S_TYPE_GAUGE:
                $oObject = Mage::getModel('littlemanco_prometheus/metrics_gauge', $aArgs);
                break;
            case Littlemanco_Prometheus_Model_Metrics_Abstract::S_TYPE_COUNTER:
                $oObject = Mage::getModel('littlemanco_prometheus/metrics_counter', $aArgs);
                break;
            default:
                throw new Littlemanco_Prometheus_Exception_InvalidMetricType($sType);
        }


        Mage::register($sRegistryKey, $oObject);


        return Mage::registry($sRegistryKey);
    }
}
