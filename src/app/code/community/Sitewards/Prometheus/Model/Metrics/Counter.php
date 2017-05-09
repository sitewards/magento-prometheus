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
 * Creates a metric of the type "counter"
 */
class Sitewards_Prometheus_Model_Metrics_Counter extends Sitewards_Prometheus_Model_Metrics_Abstract
{
    /**
     * Creates a metric of the type "counter"
     *
     * @param array $aOptions An array of the form
     *                        [
     *                          'metric_name'  => The name of the metric. Of the format vendor_extension_process_type.
     *                                            For example sitewards_prometheus_apcu_total,
     *                          'metric_help'  => The help text to provide some context on the metric for debugging
     *                          'label_titles' => [
     *                              'label_a',
     *                              'label_b'
     *                           ]
     *                        ]
     */
    public function __construct($aOptions)
    {
        $this->_checkArgs($aOptions);

        $this->sMetricName  = $aOptions[self::S_ARG_KEY_METRIC_NAME];
        $this->sMetricHelp  = $aOptions[self::S_ARG_KEY_METRIC_HELP];
        $this->aLabelTitles = $aOptions[self::S_ARG_KEY_LABEL_TITLES];

        $this->getResource()
            ->registerCounter(
                self::S_METRIC_NAMESPACE,
                $this->sMetricName,
                $this->sMetricHelp,
                $this->aLabelTitles
            );
    }

    /**
     * Updates the counter by some amount
     *
     * @param integer $iValue        The amount to increment this counter by. Defaults to 1 so single items can be
     *                               easily checkpointed
     * @param array   $aLabelValues s The values for the previously defined labels
     */
    public function increment($iValue = 1, $aLabelValues = [])
    {
        $this->getResource()
            ->getCounter(self::S_METRIC_NAMESPACE, $this->sMetricName)
            ->incBy($iValue, $aLabelValues);
    }
}
