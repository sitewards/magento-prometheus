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
 * Responsible for processing metrics as a result of events dispatched by Magento
 */
class Littlemanco_Prometheus_Model_Observer
{
    const S_INDEX_EVENT_PREFIX = 'after_reindex_process_';

    /**
     * Updates the cron model with the current timestamp
     *
     * @param Varien_Event_Observer $oEvent is ignored, but type hinted here to be explicit
     * @return void
     */
    public function checkpointCron(Varien_Event_Observer $oEvent)
    {
        Mage::getSingleton('littlemanco_prometheus/metrics_cronExecutionTimestamp')->update(now());
    }

    /**
     * Increments the number of times a cache has been flushed. Cache is determined based on the data in the event.
     *
     * @param Varien_Event_Observer $oEvent
     * @return void
     */
    public function checkpointCache(Varien_Event_Observer $oEvent)
    {
        Mage::getSingleton('littlemanco_prometheus/metrics_cacheFlushTotal')->increment($oEvent->getType());
    }

    /**
     * Increments the number of times an indexer has been run. Should only be triggered to on mass-reindexes, regardless
     * of whether they're triggererd through the admin panel.
     *
     * @param Varien_Event_Observer $oEvent
     * @return void
     */
    public function checkpointIndex(Varien_Event_Observer $oEvent)
    {
        $sName = $oEvent->getEvent()->getName();
        $sCode = str_replace(self::S_INDEX_EVENT_PREFIX, null, $sName);

        Mage::getSingleton('littlemanco_prometheus/metrics_indexerReindexTotal')->increment($sCode);
    }
}