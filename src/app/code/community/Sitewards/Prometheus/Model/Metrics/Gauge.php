<?php
/**
 * Copyright 2017 www.sitewards.com
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
 * @category Sitewards
 * @package  Sitewards_Prometheus
 * @license  apache-2.0
 */

/**
 * Creates a metric of the type "gauge"
 */
class Sitewards_Prometheus_Model_Metrics_Gauge extends Sitewards_Prometheus_Model_Metrics_Abstract
{
    /**
     * Creates a metric of the type "gauge"
     *
     * @param array $aOptions An array of the form
     *                        [
     *                          'metric_namespace' => The module name. For example, sitewards_prometheus
     *                          'metric_name'      => The name of the metric. Of the format process_type. For example
     *                                                apcu_total
     *                          'metric_help'      => The help text to provide some context on the metric for debugging
     *                          'label_titles'     => [
     *                              'label_a',
     *                              'label_b'
     *                           ]
     *                        ]
     */
    public function __construct(array $aOptions)
    {
        $this->_checkArgs($aOptions);

        $this->sMetricNamespace = $aOptions[self::S_ARG_KEY_METRIC_NAMESPACE];
        $this->sMetricName      = $aOptions[self::S_ARG_KEY_METRIC_NAME];
        $this->sMetricHelp      = $aOptions[self::S_ARG_KEY_METRIC_HELP];
        $this->aLabelTitles     = $aOptions[self::S_ARG_KEY_LABEL_TITLES];

        $this->getResource()
            ->registerGauge(
                $this->sMetricNamespace,
                $this->sMetricName,
                $this->sMetricHelp,
                $this->aLabelTitles
            );
    }

    /**
     * Updates the gauge to an arbitrary numeric value.
     *
     * @param float $fValue        The value of $this->sMetricName at the time this is called.
     * @param array $aLabelValues  The values for the previously defined labels
     */
    public function update($fValue, array $aLabelValues = [])
    {
        $this->getResource()
            ->getGauge($this->sMetricNamespace, $this->sMetricName)
            ->set($fValue, $aLabelValues);
    }
}
