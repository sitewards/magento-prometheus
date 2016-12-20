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
class Littlemanco_Prometheus_Model_Metrics_IndexerReindexTotal extends Littlemanco_Prometheus_Model_Metrics_Abstract
{
    const S_METRIC_NAME = 'indexer_reindex_total';
    const S_METRIC_HELP = 'The number of times a reindex has been triggered';

    const S_XML_PATH_CACHE_TYPES = 'global/cache/types';

    public function __construct()
    {
        $this->getResource()
            ->registerCounter(
                self::S_METRIC_NAMESPACE,
                self::S_METRIC_NAME,
                self::S_METRIC_HELP,
                ['code']
            );
    }

    /**
     * Updates the timestamp to the current time.
     *
     * @param string $sIndexCode The index that is being updated.
     */
    public function increment($sIndexCode)
    {
        $this->getResource()
            ->getCounter(self::S_METRIC_NAMESPACE, self::S_METRIC_NAME)
            ->inc([$sIndexCode]);
    }
}