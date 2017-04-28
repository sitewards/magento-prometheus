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
 * Defines an abstract model that other metrics should implement. Takes care of fetching the metrics resource; a
 * singleton that all metrics should checkpoint to.
 */
abstract class Littlemanco_Prometheus_Model_Metrics_Abstract
{
    const S_ARG_KEY_METRIC_NAME  = 'metric_name';
    const S_ARG_KEY_METRIC_HELP  = 'metric_help';
    const S_ARG_KEY_LABEL_TITLES = 'label_titles';

    const S_METRIC_NAMESPACE = 'magento';

    const S_TYPE_GAUGE   = 'gauge';
    const S_TYPE_COUNTER = 'counter';

    protected $sMetricType  = '';
    protected $sMetricName  = '';
    protected $sMetricHelp  = '';
    protected $aLabelTitles = [];

    /**
     * Provide some safety checking around the injection of arguments around the Magento instructor
     *
     * @param array $aArgs
     *
     * @throws Littlemanco_Prometheus_Exception_InvalidConstructorArguments if the arguments ars not as expected
     */
    protected function _checkArgs(array $aArgs)
    {
        $aArgKeys = [
            self::S_ARG_KEY_METRIC_NAME,
            self::S_ARG_KEY_METRIC_HELP,
            self::S_ARG_KEY_LABEL_TITLES
        ];

        foreach ($aArgKeys as $sKey) {
            if (!array_key_exists($sKey, $aArgs)) {
                throw new Littlemanco_Prometheus_Exception_InvalidConstructorArguments();
            }
        }
    }

    /**
     * @return Prometheus\CollectorRegistry
     */
    protected function getResource()
    {
        return Mage::getResourceSingleton('littlemanco_prometheus/metrics');
    }
}
