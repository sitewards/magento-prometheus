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
 * Sets the current execution time of the cron job.
 *
 * @labels none
 */
class Littlemanco_Prometheus_Model_Metrics_CronExecutionTimestamp extends Littlemanco_Prometheus_Model_Metrics_Abstract
{
    const S_METRIC_NAME = 'cron_execution_timestamp';
    const S_METRIC_HELP = 'The unix timestamp of the last cron execution';

    /**
     * Creates the timestamp metric. No matter how many times it's called, it should update this singleton.
     */
    public function __construct()
    {
        $this->getResource()
            ->registerGauge(
                self::S_METRIC_NAMESPACE,
                self::S_METRIC_NAME,
                self::S_METRIC_HELP
            );
    }

    /**
     * Updates the timestamp to the current time.
     */
    public function update()
    {
        $this->getResource()
            ->getGauge(self::S_METRIC_NAMESPACE, self::S_METRIC_NAME)
            ->set(time());
    }
}