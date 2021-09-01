<?php
/*
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * Service definition for Cloudlatencytest (v2).
 *
 * <p>
 * A Test API to report latency data.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Powerform_Google_Service_Cloudlatencytest extends Powerform_Google_Service
{
  /** View monitoring data for all of your Google Cloud and API projects. */
  const MONITORING_READONLY =
      "https://www.googleapis.com/auth/monitoring.readonly";

  public $statscollection;
  

  /**
   * Constructs the internal representation of the Cloudlatencytest service.
   *
   * @param Powerform_Google_Client $client
   */
  public function __construct(Powerform_Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://cloudlatencytest-pa.googleapis.com/';
    $this->servicePath = 'v2/statscollection/';
    $this->version = 'v2';
    $this->serviceName = 'cloudlatencytest';

    $this->statscollection = new Powerform_Google_Service_Cloudlatencytest_Statscollection_Resource(
        $this,
        $this->serviceName,
        'statscollection',
        array(
          'methods' => array(
            'updateaggregatedstats' => array(
              'path' => 'updateaggregatedstats',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),'updatestats' => array(
              'path' => 'updatestats',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),
          )
        )
    );
  }
}


/**
 * The "statscollection" collection of methods.
 * Typical usage is:
 *  <code>
 *   $cloudlatencytestService = new Powerform_Google_Service_Cloudlatencytest(...);
 *   $statscollection = $cloudlatencytestService->statscollection;
 *  </code>
 */
class Powerform_Google_Service_Cloudlatencytest_Statscollection_Resource extends Powerform_Google_Service_Resource
{

  /**
   * RPC to update the new TCP stats. (statscollection.updateaggregatedstats)
   *
   * @param Powerform_Google_AggregatedStats $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Cloudlatencytest_AggregatedStatsReply
   */
  public function updateaggregatedstats(Powerform_Google_Service_Cloudlatencytest_AggregatedStats $postBody, $optParams = array())
  {
    $params = array('postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('updateaggregatedstats', array($params), "Powerform_Google_Service_Cloudlatencytest_AggregatedStatsReply");
  }

  /**
   * RPC to update the new TCP stats. (statscollection.updatestats)
   *
   * @param Powerform_Google_Stats $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Cloudlatencytest_StatsReply
   */
  public function updatestats(Powerform_Google_Service_Cloudlatencytest_Stats $postBody, $optParams = array())
  {
    $params = array('postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('updatestats', array($params), "Powerform_Google_Service_Cloudlatencytest_StatsReply");
  }
}




class Powerform_Google_Service_Cloudlatencytest_AggregatedStats extends Powerform_Google_Collection
{
  protected $collection_key = 'stats';
  protected $internal_gapi_mappings = array(
  );
  protected $statsType = 'Powerform_Google_Service_Cloudlatencytest_Stats';
  protected $statsDataType = 'array';


  public function setStats($stats)
  {
    $this->stats = $stats;
  }
  public function getStats()
  {
    return $this->stats;
  }
}

class Powerform_Google_Service_Cloudlatencytest_AggregatedStatsReply extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $testValue;


  public function setTestValue($testValue)
  {
    $this->testValue = $testValue;
  }
  public function getTestValue()
  {
    return $this->testValue;
  }
}

class Powerform_Google_Service_Cloudlatencytest_DoubleValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $label;
  public $value;


  public function setLabel($label)
  {
    $this->label = $label;
  }
  public function getLabel()
  {
    return $this->label;
  }
  public function setValue($value)
  {
    $this->value = $value;
  }
  public function getValue()
  {
    return $this->value;
  }
}

class Powerform_Google_Service_Cloudlatencytest_IntValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $label;
  public $value;


  public function setLabel($label)
  {
    $this->label = $label;
  }
  public function getLabel()
  {
    return $this->label;
  }
  public function setValue($value)
  {
    $this->value = $value;
  }
  public function getValue()
  {
    return $this->value;
  }
}

class Powerform_Google_Service_Cloudlatencytest_Stats extends Powerform_Google_Collection
{
  protected $collection_key = 'stringValues';
  protected $internal_gapi_mappings = array(
  );
  protected $doubleValuesType = 'Powerform_Google_Service_Cloudlatencytest_DoubleValue';
  protected $doubleValuesDataType = 'array';
  protected $intValuesType = 'Powerform_Google_Service_Cloudlatencytest_IntValue';
  protected $intValuesDataType = 'array';
  protected $stringValuesType = 'Powerform_Google_Service_Cloudlatencytest_StringValue';
  protected $stringValuesDataType = 'array';
  public $time;


  public function setDoubleValues($doubleValues)
  {
    $this->doubleValues = $doubleValues;
  }
  public function getDoubleValues()
  {
    return $this->doubleValues;
  }
  public function setIntValues($intValues)
  {
    $this->intValues = $intValues;
  }
  public function getIntValues()
  {
    return $this->intValues;
  }
  public function setStringValues($stringValues)
  {
    $this->stringValues = $stringValues;
  }
  public function getStringValues()
  {
    return $this->stringValues;
  }
  public function setTime($time)
  {
    $this->time = $time;
  }
  public function getTime()
  {
    return $this->time;
  }
}

class Powerform_Google_Service_Cloudlatencytest_StatsReply extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $testValue;


  public function setTestValue($testValue)
  {
    $this->testValue = $testValue;
  }
  public function getTestValue()
  {
    return $this->testValue;
  }
}

class Powerform_Google_Service_Cloudlatencytest_StringValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $label;
  public $value;


  public function setLabel($label)
  {
    $this->label = $label;
  }
  public function getLabel()
  {
    return $this->label;
  }
  public function setValue($value)
  {
    $this->value = $value;
  }
  public function getValue()
  {
    return $this->value;
  }
}
