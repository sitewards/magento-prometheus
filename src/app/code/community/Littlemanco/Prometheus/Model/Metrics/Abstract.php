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

/**
 * Defines an abstract model that other metrics should implement. Takes care of fetching the metrics resource; a
 * singleton that all metrics should checkpoint to.
 */
class Littlemanco_Prometheus_Model_Metrics_Abstract
{
    const S_METRIC_NAMESPACE = 'magento';

    const S_METRIC_TYPE_COUNTER = 'counter';
    const S_METRIC_TYPE_GAUGE   = 'gauge';

    /**
     * @return Prometheus\CollectorRegistry
     */
    protected function getResource()
    {
        return Mage::getResourceSingleton('littlemanco_prometheus/metrics');
    }
}