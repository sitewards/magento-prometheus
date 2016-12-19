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

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;

/**
 * @todo: Implement conditional resource models based on configuration. Redis is super common in Magento, there's no
 * reason we can't persist there also.
 *
 * Not a high priority.
 */
class Littlemanco_Prometheus_Model_Resource_CollectorRegistry extends CollectorRegistry
{
    /**
     * @var Prometheus\Storage\Adapter
     */
    private $oStorageAdapter;

    /**
     * Initialize the resource model with a metric adapter
     */
    public function __construct()
    {
        $this->oStorageAdapter = new APC();

        parent::__construct($this->oStorageAdapter);
    }
}