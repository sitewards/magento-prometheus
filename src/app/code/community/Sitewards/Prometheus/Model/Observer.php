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
 * Responsible for processing metrics as a result of events dispatched by Magento
 */
class Sitewards_Prometheus_Model_Observer
{
    const S_INDEX_EVENT_PREFIX = 'after_reindex_process_';

    /**
     * Updates the cron model with the current timestamp
     *
     * @param Varien_Event_Observer $oEvent is ignored, but type hinted here to be explicit
     *
     * @return void
     */
    public function checkpointCron(Varien_Event_Observer $oEvent)
    {
        Mage::getModel('sitewards_prometheus/metricFactory')
            ->getGauge(
                'execution_timestamp',
                [
                    'metric_namespace' => 'mage_cron',
                    'metric_help'      => 'The last time (in unix time) Cron was executed'
                ]
            )
            ->update(time());
    }

    /**
     * Increments the number of times a cache has been flushed. Cache is determined based on the data in the event.
     *
     * @param Varien_Event_Observer $oEvent
     *
     * @return void
     */
    public function checkpointCache(Varien_Event_Observer $oEvent)
    {
        Mage::getModel('sitewards_prometheus/metricFactory')
            ->getCounter(
                'flush_total',
                [
                    'metric_namespace' => 'mage_cache',
                    'metric_help'      => 'The total number of times the cache has been flushed.',
                    'label_titles'     => ['type']
                ]
            )
            ->increment(1, [$oEvent->getType()]);
    }

    /**
     * Increments the number of times an indexer has been run. Should only be triggered to on mass-reindexes, regardless
     * of whether they're triggererd through the admin panel.
     *
     * @param Varien_Event_Observer $oEvent
     *
     * @return void
     */
    public function checkpointIndex(Varien_Event_Observer $oEvent)
    {
        $sName = $oEvent->getEvent()->getName();
        $sCode = str_replace(self::S_INDEX_EVENT_PREFIX, null, $sName);

        Mage::getModel('sitewards_prometheus/metricFactory')
            ->getCounter(
                'reindex_total',
                [
                    'metric_namespace' => 'mage_indexer',
                    'metric_help'      => 'The total number of times the index has been reset',
                    'label_titles'     => ['type']
                ]
            )
            ->increment(1, [$sCode]);
    }
}
