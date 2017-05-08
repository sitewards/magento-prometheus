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

class Littlemanco_Prometheus_Exception_InvalidMetricType extends Exception
{
    /**
     * Modifies the message such that it is more descriptive when rendered
     *
     * @param string         $sMetricType
     * @param int            $iCode
     * @param Exception|null $mPrevious
     */
    public function __construct($sMetricType, $iCode = 0, Exception $mPrevious = null)
    {
        $sMessage = sprintf('Metric type "%s" does not exist', $sMetricType);

        parent::__construct($sMessage, $iCode, $mPrevious);
    }
}
