<?php
/*
 * Copyright 2016 Google Inc.
 *
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
 * Service definition for Sheets (v4).
 *
 * <p>
 * An API for reading and modifying Google Sheets.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/sheets/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Powerform_Google_Service_Sheets extends Powerform_Google_Service
{
  /** View and manage the files in your Google Drive. */
  const DRIVE =
      "https://www.googleapis.com/auth/drive";
  /** View the files in your Google Drive. */
  const DRIVE_READONLY =
      "https://www.googleapis.com/auth/drive.readonly";
  /** View and manage your spreadsheets in Google Drive. */
  const SPREADSHEETS =
      "https://www.googleapis.com/auth/spreadsheets";
  /** View your Google Spreadsheets. */
  const SPREADSHEETS_READONLY =
      "https://www.googleapis.com/auth/spreadsheets.readonly";

  public $spreadsheets;
  public $spreadsheets_sheets;
  public $spreadsheets_values;
  

  /**
   * Constructs the internal representation of the Sheets service.
   *
   * @param Powerform_Google_Client $client
   */
  public function __construct(Powerform_Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://sheets.googleapis.com/';
    $this->servicePath = '';
    $this->version = 'v4';
    $this->serviceName = 'sheets';

    $this->spreadsheets = new Powerform_Google_Service_Sheets_Spreadsheets_Resource(
        $this,
        $this->serviceName,
        'spreadsheets',
        array(
          'methods' => array(
            'batchUpdate' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}:batchUpdate',
              'httpMethod' => 'POST',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'create' => array(
              'path' => 'v4/spreadsheets',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),'get' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'ranges' => array(
                  'location' => 'query',
                  'type' => 'string',
                  'repeated' => true,
                ),
                'includeGridData' => array(
                  'location' => 'query',
                  'type' => 'boolean',
                ),
              ),
            ),
          )
        )
    );
    $this->spreadsheets_sheets = new Powerform_Google_Service_Sheets_SpreadsheetsSheets_Resource(
        $this,
        $this->serviceName,
        'sheets',
        array(
          'methods' => array(
            'copyTo' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}/sheets/{sheetId}:copyTo',
              'httpMethod' => 'POST',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'sheetId' => array(
                  'location' => 'path',
                  'type' => 'integer',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
    $this->spreadsheets_values = new Powerform_Google_Service_Sheets_SpreadsheetsValues_Resource(
        $this,
        $this->serviceName,
        'values',
        array(
          'methods' => array(
            'batchGet' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}/values:batchGet',
              'httpMethod' => 'GET',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'ranges' => array(
                  'location' => 'query',
                  'type' => 'string',
                  'repeated' => true,
                ),
                'valueRenderOption' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'dateTimeRenderOption' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'majorDimension' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'batchUpdate' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}/values:batchUpdate',
              'httpMethod' => 'POST',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}/values/{range}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'range' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'valueRenderOption' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'dateTimeRenderOption' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'majorDimension' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'update' => array(
              'path' => 'v4/spreadsheets/{spreadsheetId}/values/{range}',
              'httpMethod' => 'PUT',
              'parameters' => array(
                'spreadsheetId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'range' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'valueInputOption' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),
          )
        )
    );
  }
}


/**
 * The "spreadsheets" collection of methods.
 * Typical usage is:
 *  <code>
 *   $sheetsService = new Powerform_Google_Service_Sheets(...);
 *   $spreadsheets = $sheetsService->spreadsheets;
 *  </code>
 */
class Powerform_Google_Service_Sheets_Spreadsheets_Resource extends Powerform_Google_Service_Resource
{

  /**
   * Applies one or more updates to the spreadsheet.
   *
   * Each request is validated before being applied. If any request is not valid
   * then the entire request will fail and nothing will be applied.
   *
   * Some requests have replies to give you some information about how they
   * applied. The replies will mirror the requests.  For example, if you applied 4
   * updates and the 3rd one had a reply, then the response will have 2 empty
   * replies, the actual reply, and another empty reply, in that order.
   *
   * Due to the collaborative nature of spreadsheets, it is not guaranteed that
   * the spreadsheet will reflect exactly your changes after this completes,
   * however it is guaranteed that all the updates in the request will be applied
   * atomically. Your changes may be altered with respect to collaborator changes.
   * If there are no collaborators, the spreadsheet should reflect your changes.
   * (spreadsheets.batchUpdate)
   *
   * @param string $spreadsheetId The spreadsheet to apply the updates to.
   * @param Powerform_Google_BatchUpdateSpreadsheetRequest $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Sheets_BatchUpdateSpreadsheetResponse
   */
  public function batchUpdate($spreadsheetId, Powerform_Google_Service_Sheets_BatchUpdateSpreadsheetRequest $postBody, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('batchUpdate', array($params), "Powerform_Google_Service_Sheets_BatchUpdateSpreadsheetResponse");
  }

  /**
   * Creates a spreadsheet, returning the newly created spreadsheet.
   * (spreadsheets.create)
   *
   * @param Powerform_Google_Spreadsheet $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Sheets_Spreadsheet
   */
  public function create(Powerform_Google_Service_Sheets_Spreadsheet $postBody, $optParams = array())
  {
    $params = array('postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Powerform_Google_Service_Sheets_Spreadsheet");
  }

  /**
   * Returns the spreadsheet at the given id. The caller must specify the
   * spreadsheet ID.
   *
   * By default, data within grids will not be returned. You can include grid data
   * one of two ways: specify a field mask listing your desired fields (using the
   * `fields` URL parameter in HTTP, or `FieldMaskContext.response_mask` in the
   * request extensions in an RPC), or by setting the includeGridData URL
   * parameter to true.  If a field mask is set, the `includeGridData` parameter
   * is ignored.
   *
   * For large spreadsheets, it is recommended to retrieve only the specific
   * fields of the spreadsheet that you want.
   *
   * To retrieve only subsets of the spreadsheet, use the ranges URL parameter.
   * Multiple ranges can be specified.  Limiting the range will return only the
   * portions of the spreadsheet that intersect the requested ranges. Ranges are
   * specified using A1 notation. (spreadsheets.get)
   *
   * @param string $spreadsheetId The spreadsheet to request.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string ranges The ranges to retrieve from the spreadsheet.
   * @opt_param bool includeGridData True if grid data should be returned. This
   * parameter is ignored if a field mask was set in the request.
   * @return Powerform_Google_Service_Sheets_Spreadsheet
   */
  public function get($spreadsheetId, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Powerform_Google_Service_Sheets_Spreadsheet");
  }
}

/**
 * The "sheets" collection of methods.
 * Typical usage is:
 *  <code>
 *   $sheetsService = new Powerform_Google_Service_Sheets(...);
 *   $sheets = $sheetsService->sheets;
 *  </code>
 */
class Powerform_Google_Service_Sheets_SpreadsheetsSheets_Resource extends Powerform_Google_Service_Resource
{

  /**
   * Copies a single sheet from a spreadsheet to another spreadsheet. Returns the
   * properties of the newly created sheet. (sheets.copyTo)
   *
   * @param string $spreadsheetId The id of the spreadsheet containing the sheet
   * to copy.
   * @param int $sheetId The ID of the sheet to copy.
   * @param Powerform_Google_CopySheetToAnotherSpreadsheetRequest $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Sheets_SheetProperties
   */
  public function copyTo($spreadsheetId, $sheetId, Powerform_Google_Service_Sheets_CopySheetToAnotherSpreadsheetRequest $postBody, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId, 'sheetId' => $sheetId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('copyTo', array($params), "Powerform_Google_Service_Sheets_SheetProperties");
  }
}
/**
 * The "values" collection of methods.
 * Typical usage is:
 *  <code>
 *   $sheetsService = new Powerform_Google_Service_Sheets(...);
 *   $values = $sheetsService->values;
 *  </code>
 */
class Powerform_Google_Service_Sheets_SpreadsheetsValues_Resource extends Powerform_Google_Service_Resource
{

  /**
   * Returns one or more ranges of values from a spreadsheet. The caller must
   * specify the spreadsheet ID and one or more ranges. (values.batchGet)
   *
   * @param string $spreadsheetId The id of the spreadsheet to retrieve data from.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string ranges The A1 notation of the values to retrieve.
   * @opt_param string valueRenderOption How values should be represented in the
   * output.
   * @opt_param string dateTimeRenderOption How dates, times, and durations should
   * be represented in the output. This is ignored if ValueRenderOption option is
   * FORMATTED_VALUE.
   * @opt_param string majorDimension The major dimension that results should use.
   *
   * For example, if the spreadsheet data is: `A1=1,B1=2,A2=3,B2=4`, then
   * requesting `range=A1:B2,majorDimension=ROWS` will return `[[1,2],[3,4]]`,
   * whereas requesting `range=A1:B2,majorDimension=COLUMNS` will return
   * `[[1,3],[2,4]]`.
   * @return Powerform_Google_Service_Sheets_BatchGetValuesResponse
   */
  public function batchGet($spreadsheetId, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId);
    $params = array_merge($params, $optParams);
    return $this->call('batchGet', array($params), "Powerform_Google_Service_Sheets_BatchGetValuesResponse");
  }

  /**
   * Sets values in a range of a spreadsheet. The caller must specify the
   * spreadsheet ID, a valueInputOption, and one or more ValueRanges.
   * (values.batchUpdate)
   *
   * @param string $spreadsheetId The id of the spreadsheet to update.
   * @param Powerform_Google_BatchUpdateValuesRequest $postBody
   * @param array $optParams Optional parameters.
   * @return Powerform_Google_Service_Sheets_BatchUpdateValuesResponse
   */
  public function batchUpdate($spreadsheetId, Powerform_Google_Service_Sheets_BatchUpdateValuesRequest $postBody, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('batchUpdate', array($params), "Powerform_Google_Service_Sheets_BatchUpdateValuesResponse");
  }

  /**
   * Returns a range of values from a spreadsheet. The caller must specify the
   * spreadsheet ID and a range. (values.get)
   *
   * @param string $spreadsheetId The id of the spreadsheet to retrieve data from.
   * @param string $range The A1 notation of the values to retrieve.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string valueRenderOption How values should be represented in the
   * output.
   * @opt_param string dateTimeRenderOption How dates, times, and durations should
   * be represented in the output. This is ignored if the ValueRenderOption option
   * is FORMATTED_VALUE.
   * @opt_param string majorDimension The major dimension that results should use.
   *
   * For example, if the spreadsheet data is: `A1=1,B1=2,A2=3,B2=4`, then
   * requesting `range=A1:B2,majorDimension=ROWS` will return `[[1,2],[3,4]]`,
   * whereas requesting `range=A1:B2,majorDimension=COLUMNS` will return
   * `[[1,3],[2,4]]`.
   * @return Powerform_Google_Service_Sheets_ValueRange
   */
  public function get($spreadsheetId, $range, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId, 'range' => $range);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Powerform_Google_Service_Sheets_ValueRange");
  }

  /**
   * Sets values in a range of a spreadsheet. The caller must specify the
   * spreadsheet ID, range, and a valueInputOption. (values.update)
   *
   * @param string $spreadsheetId The id of the spreadsheet to update.
   * @param string $range The A1 notation of the values to update.
   * @param Powerform_Google_ValueRange $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string valueInputOption How the input data should be interpreted.
   * @return Powerform_Google_Service_Sheets_UpdateValuesResponse
   */
  public function update($spreadsheetId, $range, Powerform_Google_Service_Sheets_ValueRange $postBody, $optParams = array())
  {
    $params = array('spreadsheetId' => $spreadsheetId, 'range' => $range, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('update', array($params), "Powerform_Google_Service_Sheets_UpdateValuesResponse");
  }
}




class Powerform_Google_Service_Sheets_AddChartRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $chartType = 'Powerform_Google_Service_Sheets_EmbeddedChart';
  protected $chartDataType = '';


  public function setChart(Powerform_Google_Service_Sheets_EmbeddedChart $chart)
  {
    $this->chart = $chart;
  }
  public function getChart()
  {
    return $this->chart;
  }
}

class Powerform_Google_Service_Sheets_AddChartResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $chartType = 'Powerform_Google_Service_Sheets_EmbeddedChart';
  protected $chartDataType = '';


  public function setChart(Powerform_Google_Service_Sheets_EmbeddedChart $chart)
  {
    $this->chart = $chart;
  }
  public function getChart()
  {
    return $this->chart;
  }
}

class Powerform_Google_Service_Sheets_AddConditionalFormatRuleRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $index;
  protected $ruleType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $ruleDataType = '';


  public function setIndex($index)
  {
    $this->index = $index;
  }
  public function getIndex()
  {
    return $this->index;
  }
  public function setRule(Powerform_Google_Service_Sheets_ConditionalFormatRule $rule)
  {
    $this->rule = $rule;
  }
  public function getRule()
  {
    return $this->rule;
  }
}

class Powerform_Google_Service_Sheets_AddFilterViewRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $filterType = 'Powerform_Google_Service_Sheets_FilterView';
  protected $filterDataType = '';


  public function setFilter(Powerform_Google_Service_Sheets_FilterView $filter)
  {
    $this->filter = $filter;
  }
  public function getFilter()
  {
    return $this->filter;
  }
}

class Powerform_Google_Service_Sheets_AddFilterViewResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $filterType = 'Powerform_Google_Service_Sheets_FilterView';
  protected $filterDataType = '';


  public function setFilter(Powerform_Google_Service_Sheets_FilterView $filter)
  {
    $this->filter = $filter;
  }
  public function getFilter()
  {
    return $this->filter;
  }
}

class Powerform_Google_Service_Sheets_AddNamedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $namedRangeType = 'Powerform_Google_Service_Sheets_NamedRange';
  protected $namedRangeDataType = '';


  public function setNamedRange(Powerform_Google_Service_Sheets_NamedRange $namedRange)
  {
    $this->namedRange = $namedRange;
  }
  public function getNamedRange()
  {
    return $this->namedRange;
  }
}

class Powerform_Google_Service_Sheets_AddNamedRangeResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $namedRangeType = 'Powerform_Google_Service_Sheets_NamedRange';
  protected $namedRangeDataType = '';


  public function setNamedRange(Powerform_Google_Service_Sheets_NamedRange $namedRange)
  {
    $this->namedRange = $namedRange;
  }
  public function getNamedRange()
  {
    return $this->namedRange;
  }
}

class Powerform_Google_Service_Sheets_AddProtectedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $protectedRangeType = 'Powerform_Google_Service_Sheets_ProtectedRange';
  protected $protectedRangeDataType = '';


  public function setProtectedRange(Powerform_Google_Service_Sheets_ProtectedRange $protectedRange)
  {
    $this->protectedRange = $protectedRange;
  }
  public function getProtectedRange()
  {
    return $this->protectedRange;
  }
}

class Powerform_Google_Service_Sheets_AddProtectedRangeResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $protectedRangeType = 'Powerform_Google_Service_Sheets_ProtectedRange';
  protected $protectedRangeDataType = '';


  public function setProtectedRange(Powerform_Google_Service_Sheets_ProtectedRange $protectedRange)
  {
    $this->protectedRange = $protectedRange;
  }
  public function getProtectedRange()
  {
    return $this->protectedRange;
  }
}

class Powerform_Google_Service_Sheets_AddSheetRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SheetProperties';
  protected $propertiesDataType = '';


  public function setProperties(Powerform_Google_Service_Sheets_SheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
}

class Powerform_Google_Service_Sheets_AddSheetResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SheetProperties';
  protected $propertiesDataType = '';


  public function setProperties(Powerform_Google_Service_Sheets_SheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
}

class Powerform_Google_Service_Sheets_AppendCellsRequest extends Powerform_Google_Collection
{
  protected $collection_key = 'rows';
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $rowsType = 'Powerform_Google_Service_Sheets_RowData';
  protected $rowsDataType = 'array';
  public $sheetId;


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setRows($rows)
  {
    $this->rows = $rows;
  }
  public function getRows()
  {
    return $this->rows;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_AppendDimensionRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $dimension;
  public $length;
  public $sheetId;


  public function setDimension($dimension)
  {
    $this->dimension = $dimension;
  }
  public function getDimension()
  {
    return $this->dimension;
  }
  public function setLength($length)
  {
    $this->length = $length;
  }
  public function getLength()
  {
    return $this->length;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_AutoFillRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $sourceAndDestinationType = 'Powerform_Google_Service_Sheets_SourceAndDestination';
  protected $sourceAndDestinationDataType = '';
  public $useAlternateSeries;


  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setSourceAndDestination(Powerform_Google_Service_Sheets_SourceAndDestination $sourceAndDestination)
  {
    $this->sourceAndDestination = $sourceAndDestination;
  }
  public function getSourceAndDestination()
  {
    return $this->sourceAndDestination;
  }
  public function setUseAlternateSeries($useAlternateSeries)
  {
    $this->useAlternateSeries = $useAlternateSeries;
  }
  public function getUseAlternateSeries()
  {
    return $this->useAlternateSeries;
  }
}

class Powerform_Google_Service_Sheets_AutoResizeDimensionsRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $dimensionsType = 'Powerform_Google_Service_Sheets_DimensionRange';
  protected $dimensionsDataType = '';


  public function setDimensions(Powerform_Google_Service_Sheets_DimensionRange $dimensions)
  {
    $this->dimensions = $dimensions;
  }
  public function getDimensions()
  {
    return $this->dimensions;
  }
}

class Powerform_Google_Service_Sheets_BasicChartAxis extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $formatType = 'Powerform_Google_Service_Sheets_TextFormat';
  protected $formatDataType = '';
  public $position;
  public $title;


  public function setFormat(Powerform_Google_Service_Sheets_TextFormat $format)
  {
    $this->format = $format;
  }
  public function getFormat()
  {
    return $this->format;
  }
  public function setPosition($position)
  {
    $this->position = $position;
  }
  public function getPosition()
  {
    return $this->position;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getTitle()
  {
    return $this->title;
  }
}

class Powerform_Google_Service_Sheets_BasicChartDomain extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $domainType = 'Powerform_Google_Service_Sheets_ChartData';
  protected $domainDataType = '';


  public function setDomain(Powerform_Google_Service_Sheets_ChartData $domain)
  {
    $this->domain = $domain;
  }
  public function getDomain()
  {
    return $this->domain;
  }
}

class Powerform_Google_Service_Sheets_BasicChartSeries extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $seriesType = 'Powerform_Google_Service_Sheets_ChartData';
  protected $seriesDataType = '';
  public $targetAxis;
  public $type;


  public function setSeries(Powerform_Google_Service_Sheets_ChartData $series)
  {
    $this->series = $series;
  }
  public function getSeries()
  {
    return $this->series;
  }
  public function setTargetAxis($targetAxis)
  {
    $this->targetAxis = $targetAxis;
  }
  public function getTargetAxis()
  {
    return $this->targetAxis;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}

class Powerform_Google_Service_Sheets_BasicChartSpec extends Powerform_Google_Collection
{
  protected $collection_key = 'series';
  protected $internal_gapi_mappings = array(
  );
  protected $axisType = 'Powerform_Google_Service_Sheets_BasicChartAxis';
  protected $axisDataType = 'array';
  public $chartType;
  protected $domainsType = 'Powerform_Google_Service_Sheets_BasicChartDomain';
  protected $domainsDataType = 'array';
  public $headerCount;
  public $legendPosition;
  protected $seriesType = 'Powerform_Google_Service_Sheets_BasicChartSeries';
  protected $seriesDataType = 'array';


  public function setAxis($axis)
  {
    $this->axis = $axis;
  }
  public function getAxis()
  {
    return $this->axis;
  }
  public function setChartType($chartType)
  {
    $this->chartType = $chartType;
  }
  public function getChartType()
  {
    return $this->chartType;
  }
  public function setDomains($domains)
  {
    $this->domains = $domains;
  }
  public function getDomains()
  {
    return $this->domains;
  }
  public function setHeaderCount($headerCount)
  {
    $this->headerCount = $headerCount;
  }
  public function getHeaderCount()
  {
    return $this->headerCount;
  }
  public function setLegendPosition($legendPosition)
  {
    $this->legendPosition = $legendPosition;
  }
  public function getLegendPosition()
  {
    return $this->legendPosition;
  }
  public function setSeries($series)
  {
    $this->series = $series;
  }
  public function getSeries()
  {
    return $this->series;
  }
}

class Powerform_Google_Service_Sheets_BasicFilter extends Powerform_Google_Collection
{
  protected $collection_key = 'sortSpecs';
  protected $internal_gapi_mappings = array(
  );
  protected $criteriaType = 'Powerform_Google_Service_Sheets_FilterCriteria';
  protected $criteriaDataType = 'map';
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $sortSpecsType = 'Powerform_Google_Service_Sheets_SortSpec';
  protected $sortSpecsDataType = 'array';


  public function setCriteria($criteria)
  {
    $this->criteria = $criteria;
  }
  public function getCriteria()
  {
    return $this->criteria;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setSortSpecs($sortSpecs)
  {
    $this->sortSpecs = $sortSpecs;
  }
  public function getSortSpecs()
  {
    return $this->sortSpecs;
  }
}

class Powerform_Google_Service_Sheets_BatchGetValuesResponse extends Powerform_Google_Collection
{
  protected $collection_key = 'valueRanges';
  protected $internal_gapi_mappings = array(
  );
  public $spreadsheetId;
  protected $valueRangesType = 'Powerform_Google_Service_Sheets_ValueRange';
  protected $valueRangesDataType = 'array';


  public function setSpreadsheetId($spreadsheetId)
  {
    $this->spreadsheetId = $spreadsheetId;
  }
  public function getSpreadsheetId()
  {
    return $this->spreadsheetId;
  }
  public function setValueRanges($valueRanges)
  {
    $this->valueRanges = $valueRanges;
  }
  public function getValueRanges()
  {
    return $this->valueRanges;
  }
}

class Powerform_Google_Service_Sheets_BatchUpdateSpreadsheetRequest extends Powerform_Google_Collection
{
  protected $collection_key = 'requests';
  protected $internal_gapi_mappings = array(
  );
  protected $requestsType = 'Powerform_Google_Service_Sheets_Request';
  protected $requestsDataType = 'array';


  public function setRequests($requests)
  {
    $this->requests = $requests;
  }
  public function getRequests()
  {
    return $this->requests;
  }
}

class Powerform_Google_Service_Sheets_BatchUpdateSpreadsheetResponse extends Powerform_Google_Collection
{
  protected $collection_key = 'replies';
  protected $internal_gapi_mappings = array(
  );
  protected $repliesType = 'Powerform_Google_Service_Sheets_Response';
  protected $repliesDataType = 'array';
  public $spreadsheetId;


  public function setReplies($replies)
  {
    $this->replies = $replies;
  }
  public function getReplies()
  {
    return $this->replies;
  }
  public function setSpreadsheetId($spreadsheetId)
  {
    $this->spreadsheetId = $spreadsheetId;
  }
  public function getSpreadsheetId()
  {
    return $this->spreadsheetId;
  }
}

class Powerform_Google_Service_Sheets_BatchUpdateValuesRequest extends Powerform_Google_Collection
{
  protected $collection_key = 'data';
  protected $internal_gapi_mappings = array(
  );
  protected $dataType = 'Powerform_Google_Service_Sheets_ValueRange';
  protected $dataDataType = 'array';
  public $valueInputOption;


  public function setData($data)
  {
    $this->data = $data;
  }
  public function getData()
  {
    return $this->data;
  }
  public function setValueInputOption($valueInputOption)
  {
    $this->valueInputOption = $valueInputOption;
  }
  public function getValueInputOption()
  {
    return $this->valueInputOption;
  }
}

class Powerform_Google_Service_Sheets_BatchUpdateValuesResponse extends Powerform_Google_Collection
{
  protected $collection_key = 'responses';
  protected $internal_gapi_mappings = array(
  );
  protected $responsesType = 'Powerform_Google_Service_Sheets_UpdateValuesResponse';
  protected $responsesDataType = 'array';
  public $spreadsheetId;
  public $totalUpdatedCells;
  public $totalUpdatedColumns;
  public $totalUpdatedRows;
  public $totalUpdatedSheets;


  public function setResponses($responses)
  {
    $this->responses = $responses;
  }
  public function getResponses()
  {
    return $this->responses;
  }
  public function setSpreadsheetId($spreadsheetId)
  {
    $this->spreadsheetId = $spreadsheetId;
  }
  public function getSpreadsheetId()
  {
    return $this->spreadsheetId;
  }
  public function setTotalUpdatedCells($totalUpdatedCells)
  {
    $this->totalUpdatedCells = $totalUpdatedCells;
  }
  public function getTotalUpdatedCells()
  {
    return $this->totalUpdatedCells;
  }
  public function setTotalUpdatedColumns($totalUpdatedColumns)
  {
    $this->totalUpdatedColumns = $totalUpdatedColumns;
  }
  public function getTotalUpdatedColumns()
  {
    return $this->totalUpdatedColumns;
  }
  public function setTotalUpdatedRows($totalUpdatedRows)
  {
    $this->totalUpdatedRows = $totalUpdatedRows;
  }
  public function getTotalUpdatedRows()
  {
    return $this->totalUpdatedRows;
  }
  public function setTotalUpdatedSheets($totalUpdatedSheets)
  {
    $this->totalUpdatedSheets = $totalUpdatedSheets;
  }
  public function getTotalUpdatedSheets()
  {
    return $this->totalUpdatedSheets;
  }
}

class Powerform_Google_Service_Sheets_BooleanCondition extends Powerform_Google_Collection
{
  protected $collection_key = 'values';
  protected $internal_gapi_mappings = array(
  );
  public $type;
  protected $valuesType = 'Powerform_Google_Service_Sheets_ConditionValue';
  protected $valuesDataType = 'array';


  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
  public function setValues($values)
  {
    $this->values = $values;
  }
  public function getValues()
  {
    return $this->values;
  }
}

class Powerform_Google_Service_Sheets_BooleanRule extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $conditionType = 'Powerform_Google_Service_Sheets_BooleanCondition';
  protected $conditionDataType = '';
  protected $formatType = 'Powerform_Google_Service_Sheets_CellFormat';
  protected $formatDataType = '';


  public function setCondition(Powerform_Google_Service_Sheets_BooleanCondition $condition)
  {
    $this->condition = $condition;
  }
  public function getCondition()
  {
    return $this->condition;
  }
  public function setFormat(Powerform_Google_Service_Sheets_CellFormat $format)
  {
    $this->format = $format;
  }
  public function getFormat()
  {
    return $this->format;
  }
}

class Powerform_Google_Service_Sheets_Border extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $colorType = 'Powerform_Google_Service_Sheets_Color';
  protected $colorDataType = '';
  public $style;
  public $width;


  public function setColor(Powerform_Google_Service_Sheets_Color $color)
  {
    $this->color = $color;
  }
  public function getColor()
  {
    return $this->color;
  }
  public function setStyle($style)
  {
    $this->style = $style;
  }
  public function getStyle()
  {
    return $this->style;
  }
  public function setWidth($width)
  {
    $this->width = $width;
  }
  public function getWidth()
  {
    return $this->width;
  }
}

class Powerform_Google_Service_Sheets_Borders extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $bottomType = 'Powerform_Google_Service_Sheets_Border';
  protected $bottomDataType = '';
  protected $leftType = 'Powerform_Google_Service_Sheets_Border';
  protected $leftDataType = '';
  protected $rightType = 'Powerform_Google_Service_Sheets_Border';
  protected $rightDataType = '';
  protected $topType = 'Powerform_Google_Service_Sheets_Border';
  protected $topDataType = '';


  public function setBottom(Powerform_Google_Service_Sheets_Border $bottom)
  {
    $this->bottom = $bottom;
  }
  public function getBottom()
  {
    return $this->bottom;
  }
  public function setLeft(Powerform_Google_Service_Sheets_Border $left)
  {
    $this->left = $left;
  }
  public function getLeft()
  {
    return $this->left;
  }
  public function setRight(Powerform_Google_Service_Sheets_Border $right)
  {
    $this->right = $right;
  }
  public function getRight()
  {
    return $this->right;
  }
  public function setTop(Powerform_Google_Service_Sheets_Border $top)
  {
    $this->top = $top;
  }
  public function getTop()
  {
    return $this->top;
  }
}

class Powerform_Google_Service_Sheets_CellData extends Powerform_Google_Collection
{
  protected $collection_key = 'textFormatRuns';
  protected $internal_gapi_mappings = array(
  );
  protected $dataValidationType = 'Powerform_Google_Service_Sheets_DataValidationRule';
  protected $dataValidationDataType = '';
  protected $effectiveFormatType = 'Powerform_Google_Service_Sheets_CellFormat';
  protected $effectiveFormatDataType = '';
  protected $effectiveValueType = 'Powerform_Google_Service_Sheets_ExtendedValue';
  protected $effectiveValueDataType = '';
  public $formattedValue;
  public $hyperlink;
  public $note;
  protected $pivotTableType = 'Powerform_Google_Service_Sheets_PivotTable';
  protected $pivotTableDataType = '';
  protected $textFormatRunsType = 'Powerform_Google_Service_Sheets_TextFormatRun';
  protected $textFormatRunsDataType = 'array';
  protected $userEnteredFormatType = 'Powerform_Google_Service_Sheets_CellFormat';
  protected $userEnteredFormatDataType = '';
  protected $userEnteredValueType = 'Powerform_Google_Service_Sheets_ExtendedValue';
  protected $userEnteredValueDataType = '';


  public function setDataValidation(Powerform_Google_Service_Sheets_DataValidationRule $dataValidation)
  {
    $this->dataValidation = $dataValidation;
  }
  public function getDataValidation()
  {
    return $this->dataValidation;
  }
  public function setEffectiveFormat(Powerform_Google_Service_Sheets_CellFormat $effectiveFormat)
  {
    $this->effectiveFormat = $effectiveFormat;
  }
  public function getEffectiveFormat()
  {
    return $this->effectiveFormat;
  }
  public function setEffectiveValue(Powerform_Google_Service_Sheets_ExtendedValue $effectiveValue)
  {
    $this->effectiveValue = $effectiveValue;
  }
  public function getEffectiveValue()
  {
    return $this->effectiveValue;
  }
  public function setFormattedValue($formattedValue)
  {
    $this->formattedValue = $formattedValue;
  }
  public function getFormattedValue()
  {
    return $this->formattedValue;
  }
  public function setHyperlink($hyperlink)
  {
    $this->hyperlink = $hyperlink;
  }
  public function getHyperlink()
  {
    return $this->hyperlink;
  }
  public function setNote($note)
  {
    $this->note = $note;
  }
  public function getNote()
  {
    return $this->note;
  }
  public function setPivotTable(Powerform_Google_Service_Sheets_PivotTable $pivotTable)
  {
    $this->pivotTable = $pivotTable;
  }
  public function getPivotTable()
  {
    return $this->pivotTable;
  }
  public function setTextFormatRuns($textFormatRuns)
  {
    $this->textFormatRuns = $textFormatRuns;
  }
  public function getTextFormatRuns()
  {
    return $this->textFormatRuns;
  }
  public function setUserEnteredFormat(Powerform_Google_Service_Sheets_CellFormat $userEnteredFormat)
  {
    $this->userEnteredFormat = $userEnteredFormat;
  }
  public function getUserEnteredFormat()
  {
    return $this->userEnteredFormat;
  }
  public function setUserEnteredValue(Powerform_Google_Service_Sheets_ExtendedValue $userEnteredValue)
  {
    $this->userEnteredValue = $userEnteredValue;
  }
  public function getUserEnteredValue()
  {
    return $this->userEnteredValue;
  }
}

class Powerform_Google_Service_Sheets_CellFormat extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $backgroundColorType = 'Powerform_Google_Service_Sheets_Color';
  protected $backgroundColorDataType = '';
  protected $bordersType = 'Powerform_Google_Service_Sheets_Borders';
  protected $bordersDataType = '';
  public $horizontalAlignment;
  public $hyperlinkDisplayType;
  protected $numberFormatType = 'Powerform_Google_Service_Sheets_NumberFormat';
  protected $numberFormatDataType = '';
  protected $paddingType = 'Powerform_Google_Service_Sheets_Padding';
  protected $paddingDataType = '';
  public $textDirection;
  protected $textFormatType = 'Powerform_Google_Service_Sheets_TextFormat';
  protected $textFormatDataType = '';
  public $verticalAlignment;
  public $wrapStrategy;


  public function setBackgroundColor(Powerform_Google_Service_Sheets_Color $backgroundColor)
  {
    $this->backgroundColor = $backgroundColor;
  }
  public function getBackgroundColor()
  {
    return $this->backgroundColor;
  }
  public function setBorders(Powerform_Google_Service_Sheets_Borders $borders)
  {
    $this->borders = $borders;
  }
  public function getBorders()
  {
    return $this->borders;
  }
  public function setHorizontalAlignment($horizontalAlignment)
  {
    $this->horizontalAlignment = $horizontalAlignment;
  }
  public function getHorizontalAlignment()
  {
    return $this->horizontalAlignment;
  }
  public function setHyperlinkDisplayType($hyperlinkDisplayType)
  {
    $this->hyperlinkDisplayType = $hyperlinkDisplayType;
  }
  public function getHyperlinkDisplayType()
  {
    return $this->hyperlinkDisplayType;
  }
  public function setNumberFormat(Powerform_Google_Service_Sheets_NumberFormat $numberFormat)
  {
    $this->numberFormat = $numberFormat;
  }
  public function getNumberFormat()
  {
    return $this->numberFormat;
  }
  public function setPadding(Powerform_Google_Service_Sheets_Padding $padding)
  {
    $this->padding = $padding;
  }
  public function getPadding()
  {
    return $this->padding;
  }
  public function setTextDirection($textDirection)
  {
    $this->textDirection = $textDirection;
  }
  public function getTextDirection()
  {
    return $this->textDirection;
  }
  public function setTextFormat(Powerform_Google_Service_Sheets_TextFormat $textFormat)
  {
    $this->textFormat = $textFormat;
  }
  public function getTextFormat()
  {
    return $this->textFormat;
  }
  public function setVerticalAlignment($verticalAlignment)
  {
    $this->verticalAlignment = $verticalAlignment;
  }
  public function getVerticalAlignment()
  {
    return $this->verticalAlignment;
  }
  public function setWrapStrategy($wrapStrategy)
  {
    $this->wrapStrategy = $wrapStrategy;
  }
  public function getWrapStrategy()
  {
    return $this->wrapStrategy;
  }
}

class Powerform_Google_Service_Sheets_ChartData extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $sourceRangeType = 'Powerform_Google_Service_Sheets_ChartSourceRange';
  protected $sourceRangeDataType = '';


  public function setSourceRange(Powerform_Google_Service_Sheets_ChartSourceRange $sourceRange)
  {
    $this->sourceRange = $sourceRange;
  }
  public function getSourceRange()
  {
    return $this->sourceRange;
  }
}

class Powerform_Google_Service_Sheets_ChartSourceRange extends Powerform_Google_Collection
{
  protected $collection_key = 'sources';
  protected $internal_gapi_mappings = array(
  );
  protected $sourcesType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourcesDataType = 'array';


  public function setSources($sources)
  {
    $this->sources = $sources;
  }
  public function getSources()
  {
    return $this->sources;
  }
}

class Powerform_Google_Service_Sheets_ChartSpec extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $basicChartType = 'Powerform_Google_Service_Sheets_BasicChartSpec';
  protected $basicChartDataType = '';
  public $hiddenDimensionStrategy;
  protected $pieChartType = 'Powerform_Google_Service_Sheets_PieChartSpec';
  protected $pieChartDataType = '';
  public $title;


  public function setBasicChart(Powerform_Google_Service_Sheets_BasicChartSpec $basicChart)
  {
    $this->basicChart = $basicChart;
  }
  public function getBasicChart()
  {
    return $this->basicChart;
  }
  public function setHiddenDimensionStrategy($hiddenDimensionStrategy)
  {
    $this->hiddenDimensionStrategy = $hiddenDimensionStrategy;
  }
  public function getHiddenDimensionStrategy()
  {
    return $this->hiddenDimensionStrategy;
  }
  public function setPieChart(Powerform_Google_Service_Sheets_PieChartSpec $pieChart)
  {
    $this->pieChart = $pieChart;
  }
  public function getPieChart()
  {
    return $this->pieChart;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getTitle()
  {
    return $this->title;
  }
}

class Powerform_Google_Service_Sheets_ClearBasicFilterRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $sheetId;


  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_Color extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $alpha;
  public $blue;
  public $green;
  public $red;


  public function setAlpha($alpha)
  {
    $this->alpha = $alpha;
  }
  public function getAlpha()
  {
    return $this->alpha;
  }
  public function setBlue($blue)
  {
    $this->blue = $blue;
  }
  public function getBlue()
  {
    return $this->blue;
  }
  public function setGreen($green)
  {
    $this->green = $green;
  }
  public function getGreen()
  {
    return $this->green;
  }
  public function setRed($red)
  {
    $this->red = $red;
  }
  public function getRed()
  {
    return $this->red;
  }
}

class Powerform_Google_Service_Sheets_ConditionValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $relativeDate;
  public $userEnteredValue;


  public function setRelativeDate($relativeDate)
  {
    $this->relativeDate = $relativeDate;
  }
  public function getRelativeDate()
  {
    return $this->relativeDate;
  }
  public function setUserEnteredValue($userEnteredValue)
  {
    $this->userEnteredValue = $userEnteredValue;
  }
  public function getUserEnteredValue()
  {
    return $this->userEnteredValue;
  }
}

class Powerform_Google_Service_Sheets_ConditionalFormatRule extends Powerform_Google_Collection
{
  protected $collection_key = 'ranges';
  protected $internal_gapi_mappings = array(
  );
  protected $booleanRuleType = 'Powerform_Google_Service_Sheets_BooleanRule';
  protected $booleanRuleDataType = '';
  protected $gradientRuleType = 'Powerform_Google_Service_Sheets_GradientRule';
  protected $gradientRuleDataType = '';
  protected $rangesType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangesDataType = 'array';


  public function setBooleanRule(Powerform_Google_Service_Sheets_BooleanRule $booleanRule)
  {
    $this->booleanRule = $booleanRule;
  }
  public function getBooleanRule()
  {
    return $this->booleanRule;
  }
  public function setGradientRule(Powerform_Google_Service_Sheets_GradientRule $gradientRule)
  {
    $this->gradientRule = $gradientRule;
  }
  public function getGradientRule()
  {
    return $this->gradientRule;
  }
  public function setRanges($ranges)
  {
    $this->ranges = $ranges;
  }
  public function getRanges()
  {
    return $this->ranges;
  }
}

class Powerform_Google_Service_Sheets_CopyPasteRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $destinationType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $destinationDataType = '';
  public $pasteOrientation;
  public $pasteType;
  protected $sourceType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourceDataType = '';


  public function setDestination(Powerform_Google_Service_Sheets_GridRange $destination)
  {
    $this->destination = $destination;
  }
  public function getDestination()
  {
    return $this->destination;
  }
  public function setPasteOrientation($pasteOrientation)
  {
    $this->pasteOrientation = $pasteOrientation;
  }
  public function getPasteOrientation()
  {
    return $this->pasteOrientation;
  }
  public function setPasteType($pasteType)
  {
    $this->pasteType = $pasteType;
  }
  public function getPasteType()
  {
    return $this->pasteType;
  }
  public function setSource(Powerform_Google_Service_Sheets_GridRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Powerform_Google_Service_Sheets_CopySheetToAnotherSpreadsheetRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $destinationSpreadsheetId;


  public function setDestinationSpreadsheetId($destinationSpreadsheetId)
  {
    $this->destinationSpreadsheetId = $destinationSpreadsheetId;
  }
  public function getDestinationSpreadsheetId()
  {
    return $this->destinationSpreadsheetId;
  }
}

class Powerform_Google_Service_Sheets_CutPasteRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $destinationType = 'Powerform_Google_Service_Sheets_GridCoordinate';
  protected $destinationDataType = '';
  public $pasteType;
  protected $sourceType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourceDataType = '';


  public function setDestination(Powerform_Google_Service_Sheets_GridCoordinate $destination)
  {
    $this->destination = $destination;
  }
  public function getDestination()
  {
    return $this->destination;
  }
  public function setPasteType($pasteType)
  {
    $this->pasteType = $pasteType;
  }
  public function getPasteType()
  {
    return $this->pasteType;
  }
  public function setSource(Powerform_Google_Service_Sheets_GridRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Powerform_Google_Service_Sheets_DataValidationRule extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $conditionType = 'Powerform_Google_Service_Sheets_BooleanCondition';
  protected $conditionDataType = '';
  public $inputMessage;
  public $showCustomUi;
  public $strict;


  public function setCondition(Powerform_Google_Service_Sheets_BooleanCondition $condition)
  {
    $this->condition = $condition;
  }
  public function getCondition()
  {
    return $this->condition;
  }
  public function setInputMessage($inputMessage)
  {
    $this->inputMessage = $inputMessage;
  }
  public function getInputMessage()
  {
    return $this->inputMessage;
  }
  public function setShowCustomUi($showCustomUi)
  {
    $this->showCustomUi = $showCustomUi;
  }
  public function getShowCustomUi()
  {
    return $this->showCustomUi;
  }
  public function setStrict($strict)
  {
    $this->strict = $strict;
  }
  public function getStrict()
  {
    return $this->strict;
  }
}

class Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $index;
  public $sheetId;


  public function setIndex($index)
  {
    $this->index = $index;
  }
  public function getIndex()
  {
    return $this->index;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $ruleType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $ruleDataType = '';


  public function setRule(Powerform_Google_Service_Sheets_ConditionalFormatRule $rule)
  {
    $this->rule = $rule;
  }
  public function getRule()
  {
    return $this->rule;
  }
}

class Powerform_Google_Service_Sheets_DeleteDimensionRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $rangeType = 'Powerform_Google_Service_Sheets_DimensionRange';
  protected $rangeDataType = '';


  public function setRange(Powerform_Google_Service_Sheets_DimensionRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_DeleteEmbeddedObjectRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $objectId;


  public function setObjectId($objectId)
  {
    $this->objectId = $objectId;
  }
  public function getObjectId()
  {
    return $this->objectId;
  }
}

class Powerform_Google_Service_Sheets_DeleteFilterViewRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $filterId;


  public function setFilterId($filterId)
  {
    $this->filterId = $filterId;
  }
  public function getFilterId()
  {
    return $this->filterId;
  }
}

class Powerform_Google_Service_Sheets_DeleteNamedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $namedRangeId;


  public function setNamedRangeId($namedRangeId)
  {
    $this->namedRangeId = $namedRangeId;
  }
  public function getNamedRangeId()
  {
    return $this->namedRangeId;
  }
}

class Powerform_Google_Service_Sheets_DeleteProtectedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $protectedRangeId;


  public function setProtectedRangeId($protectedRangeId)
  {
    $this->protectedRangeId = $protectedRangeId;
  }
  public function getProtectedRangeId()
  {
    return $this->protectedRangeId;
  }
}

class Powerform_Google_Service_Sheets_DeleteSheetRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $sheetId;


  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_DimensionProperties extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $hiddenByFilter;
  public $hiddenByUser;
  public $pixelSize;


  public function setHiddenByFilter($hiddenByFilter)
  {
    $this->hiddenByFilter = $hiddenByFilter;
  }
  public function getHiddenByFilter()
  {
    return $this->hiddenByFilter;
  }
  public function setHiddenByUser($hiddenByUser)
  {
    $this->hiddenByUser = $hiddenByUser;
  }
  public function getHiddenByUser()
  {
    return $this->hiddenByUser;
  }
  public function setPixelSize($pixelSize)
  {
    $this->pixelSize = $pixelSize;
  }
  public function getPixelSize()
  {
    return $this->pixelSize;
  }
}

class Powerform_Google_Service_Sheets_DimensionRange extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $dimension;
  public $endIndex;
  public $sheetId;
  public $startIndex;


  public function setDimension($dimension)
  {
    $this->dimension = $dimension;
  }
  public function getDimension()
  {
    return $this->dimension;
  }
  public function setEndIndex($endIndex)
  {
    $this->endIndex = $endIndex;
  }
  public function getEndIndex()
  {
    return $this->endIndex;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
  public function setStartIndex($startIndex)
  {
    $this->startIndex = $startIndex;
  }
  public function getStartIndex()
  {
    return $this->startIndex;
  }
}

class Powerform_Google_Service_Sheets_DuplicateFilterViewRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $filterId;


  public function setFilterId($filterId)
  {
    $this->filterId = $filterId;
  }
  public function getFilterId()
  {
    return $this->filterId;
  }
}

class Powerform_Google_Service_Sheets_DuplicateFilterViewResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $filterType = 'Powerform_Google_Service_Sheets_FilterView';
  protected $filterDataType = '';


  public function setFilter(Powerform_Google_Service_Sheets_FilterView $filter)
  {
    $this->filter = $filter;
  }
  public function getFilter()
  {
    return $this->filter;
  }
}

class Powerform_Google_Service_Sheets_DuplicateSheetRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $insertSheetIndex;
  public $newSheetId;
  public $newSheetName;
  public $sourceSheetId;


  public function setInsertSheetIndex($insertSheetIndex)
  {
    $this->insertSheetIndex = $insertSheetIndex;
  }
  public function getInsertSheetIndex()
  {
    return $this->insertSheetIndex;
  }
  public function setNewSheetId($newSheetId)
  {
    $this->newSheetId = $newSheetId;
  }
  public function getNewSheetId()
  {
    return $this->newSheetId;
  }
  public function setNewSheetName($newSheetName)
  {
    $this->newSheetName = $newSheetName;
  }
  public function getNewSheetName()
  {
    return $this->newSheetName;
  }
  public function setSourceSheetId($sourceSheetId)
  {
    $this->sourceSheetId = $sourceSheetId;
  }
  public function getSourceSheetId()
  {
    return $this->sourceSheetId;
  }
}

class Powerform_Google_Service_Sheets_DuplicateSheetResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SheetProperties';
  protected $propertiesDataType = '';


  public function setProperties(Powerform_Google_Service_Sheets_SheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
}

class Powerform_Google_Service_Sheets_Editors extends Powerform_Google_Collection
{
  protected $collection_key = 'users';
  protected $internal_gapi_mappings = array(
  );
  public $domainUsersCanEdit;
  public $groups;
  public $users;


  public function setDomainUsersCanEdit($domainUsersCanEdit)
  {
    $this->domainUsersCanEdit = $domainUsersCanEdit;
  }
  public function getDomainUsersCanEdit()
  {
    return $this->domainUsersCanEdit;
  }
  public function setGroups($groups)
  {
    $this->groups = $groups;
  }
  public function getGroups()
  {
    return $this->groups;
  }
  public function setUsers($users)
  {
    $this->users = $users;
  }
  public function getUsers()
  {
    return $this->users;
  }
}

class Powerform_Google_Service_Sheets_EmbeddedChart extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $chartId;
  protected $positionType = 'Powerform_Google_Service_Sheets_EmbeddedObjectPosition';
  protected $positionDataType = '';
  protected $specType = 'Powerform_Google_Service_Sheets_ChartSpec';
  protected $specDataType = '';


  public function setChartId($chartId)
  {
    $this->chartId = $chartId;
  }
  public function getChartId()
  {
    return $this->chartId;
  }
  public function setPosition(Powerform_Google_Service_Sheets_EmbeddedObjectPosition $position)
  {
    $this->position = $position;
  }
  public function getPosition()
  {
    return $this->position;
  }
  public function setSpec(Powerform_Google_Service_Sheets_ChartSpec $spec)
  {
    $this->spec = $spec;
  }
  public function getSpec()
  {
    return $this->spec;
  }
}

class Powerform_Google_Service_Sheets_EmbeddedObjectPosition extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $newSheet;
  protected $overlayPositionType = 'Powerform_Google_Service_Sheets_OverlayPosition';
  protected $overlayPositionDataType = '';
  public $sheetId;


  public function setNewSheet($newSheet)
  {
    $this->newSheet = $newSheet;
  }
  public function getNewSheet()
  {
    return $this->newSheet;
  }
  public function setOverlayPosition(Powerform_Google_Service_Sheets_OverlayPosition $overlayPosition)
  {
    $this->overlayPosition = $overlayPosition;
  }
  public function getOverlayPosition()
  {
    return $this->overlayPosition;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_ErrorValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $message;
  public $type;


  public function setMessage($message)
  {
    $this->message = $message;
  }
  public function getMessage()
  {
    return $this->message;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}

class Powerform_Google_Service_Sheets_ExtendedValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $boolValue;
  protected $errorValueType = 'Powerform_Google_Service_Sheets_ErrorValue';
  protected $errorValueDataType = '';
  public $formulaValue;
  public $numberValue;
  public $stringValue;


  public function setBoolValue($boolValue)
  {
    $this->boolValue = $boolValue;
  }
  public function getBoolValue()
  {
    return $this->boolValue;
  }
  public function setErrorValue(Powerform_Google_Service_Sheets_ErrorValue $errorValue)
  {
    $this->errorValue = $errorValue;
  }
  public function getErrorValue()
  {
    return $this->errorValue;
  }
  public function setFormulaValue($formulaValue)
  {
    $this->formulaValue = $formulaValue;
  }
  public function getFormulaValue()
  {
    return $this->formulaValue;
  }
  public function setNumberValue($numberValue)
  {
    $this->numberValue = $numberValue;
  }
  public function getNumberValue()
  {
    return $this->numberValue;
  }
  public function setStringValue($stringValue)
  {
    $this->stringValue = $stringValue;
  }
  public function getStringValue()
  {
    return $this->stringValue;
  }
}

class Powerform_Google_Service_Sheets_FilterCriteria extends Powerform_Google_Collection
{
  protected $collection_key = 'hiddenValues';
  protected $internal_gapi_mappings = array(
  );
  protected $conditionType = 'Powerform_Google_Service_Sheets_BooleanCondition';
  protected $conditionDataType = '';
  public $hiddenValues;


  public function setCondition(Powerform_Google_Service_Sheets_BooleanCondition $condition)
  {
    $this->condition = $condition;
  }
  public function getCondition()
  {
    return $this->condition;
  }
  public function setHiddenValues($hiddenValues)
  {
    $this->hiddenValues = $hiddenValues;
  }
  public function getHiddenValues()
  {
    return $this->hiddenValues;
  }
}

class Powerform_Google_Service_Sheets_FilterView extends Powerform_Google_Collection
{
  protected $collection_key = 'sortSpecs';
  protected $internal_gapi_mappings = array(
  );
  protected $criteriaType = 'Powerform_Google_Service_Sheets_FilterCriteria';
  protected $criteriaDataType = 'map';
  public $filterViewId;
  public $namedRangeId;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $sortSpecsType = 'Powerform_Google_Service_Sheets_SortSpec';
  protected $sortSpecsDataType = 'array';
  public $title;


  public function setCriteria($criteria)
  {
    $this->criteria = $criteria;
  }
  public function getCriteria()
  {
    return $this->criteria;
  }
  public function setFilterViewId($filterViewId)
  {
    $this->filterViewId = $filterViewId;
  }
  public function getFilterViewId()
  {
    return $this->filterViewId;
  }
  public function setNamedRangeId($namedRangeId)
  {
    $this->namedRangeId = $namedRangeId;
  }
  public function getNamedRangeId()
  {
    return $this->namedRangeId;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setSortSpecs($sortSpecs)
  {
    $this->sortSpecs = $sortSpecs;
  }
  public function getSortSpecs()
  {
    return $this->sortSpecs;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getTitle()
  {
    return $this->title;
  }
}

class Powerform_Google_Service_Sheets_FindReplaceRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $allSheets;
  public $find;
  public $includeFormulas;
  public $matchCase;
  public $matchEntireCell;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  public $replacement;
  public $searchByRegex;
  public $sheetId;


  public function setAllSheets($allSheets)
  {
    $this->allSheets = $allSheets;
  }
  public function getAllSheets()
  {
    return $this->allSheets;
  }
  public function setFind($find)
  {
    $this->find = $find;
  }
  public function getFind()
  {
    return $this->find;
  }
  public function setIncludeFormulas($includeFormulas)
  {
    $this->includeFormulas = $includeFormulas;
  }
  public function getIncludeFormulas()
  {
    return $this->includeFormulas;
  }
  public function setMatchCase($matchCase)
  {
    $this->matchCase = $matchCase;
  }
  public function getMatchCase()
  {
    return $this->matchCase;
  }
  public function setMatchEntireCell($matchEntireCell)
  {
    $this->matchEntireCell = $matchEntireCell;
  }
  public function getMatchEntireCell()
  {
    return $this->matchEntireCell;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setReplacement($replacement)
  {
    $this->replacement = $replacement;
  }
  public function getReplacement()
  {
    return $this->replacement;
  }
  public function setSearchByRegex($searchByRegex)
  {
    $this->searchByRegex = $searchByRegex;
  }
  public function getSearchByRegex()
  {
    return $this->searchByRegex;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_FindReplaceResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $formulasChanged;
  public $occurrencesChanged;
  public $rowsChanged;
  public $sheetsChanged;
  public $valuesChanged;


  public function setFormulasChanged($formulasChanged)
  {
    $this->formulasChanged = $formulasChanged;
  }
  public function getFormulasChanged()
  {
    return $this->formulasChanged;
  }
  public function setOccurrencesChanged($occurrencesChanged)
  {
    $this->occurrencesChanged = $occurrencesChanged;
  }
  public function getOccurrencesChanged()
  {
    return $this->occurrencesChanged;
  }
  public function setRowsChanged($rowsChanged)
  {
    $this->rowsChanged = $rowsChanged;
  }
  public function getRowsChanged()
  {
    return $this->rowsChanged;
  }
  public function setSheetsChanged($sheetsChanged)
  {
    $this->sheetsChanged = $sheetsChanged;
  }
  public function getSheetsChanged()
  {
    return $this->sheetsChanged;
  }
  public function setValuesChanged($valuesChanged)
  {
    $this->valuesChanged = $valuesChanged;
  }
  public function getValuesChanged()
  {
    return $this->valuesChanged;
  }
}

class Powerform_Google_Service_Sheets_GradientRule extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $maxpointType = 'Powerform_Google_Service_Sheets_InterpolationPoint';
  protected $maxpointDataType = '';
  protected $midpointType = 'Powerform_Google_Service_Sheets_InterpolationPoint';
  protected $midpointDataType = '';
  protected $minpointType = 'Powerform_Google_Service_Sheets_InterpolationPoint';
  protected $minpointDataType = '';


  public function setMaxpoint(Powerform_Google_Service_Sheets_InterpolationPoint $maxpoint)
  {
    $this->maxpoint = $maxpoint;
  }
  public function getMaxpoint()
  {
    return $this->maxpoint;
  }
  public function setMidpoint(Powerform_Google_Service_Sheets_InterpolationPoint $midpoint)
  {
    $this->midpoint = $midpoint;
  }
  public function getMidpoint()
  {
    return $this->midpoint;
  }
  public function setMinpoint(Powerform_Google_Service_Sheets_InterpolationPoint $minpoint)
  {
    $this->minpoint = $minpoint;
  }
  public function getMinpoint()
  {
    return $this->minpoint;
  }
}

class Powerform_Google_Service_Sheets_GridCoordinate extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $columnIndex;
  public $rowIndex;
  public $sheetId;


  public function setColumnIndex($columnIndex)
  {
    $this->columnIndex = $columnIndex;
  }
  public function getColumnIndex()
  {
    return $this->columnIndex;
  }
  public function setRowIndex($rowIndex)
  {
    $this->rowIndex = $rowIndex;
  }
  public function getRowIndex()
  {
    return $this->rowIndex;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_GridData extends Powerform_Google_Collection
{
  protected $collection_key = 'rowMetadata';
  protected $internal_gapi_mappings = array(
  );
  protected $columnMetadataType = 'Powerform_Google_Service_Sheets_DimensionProperties';
  protected $columnMetadataDataType = 'array';
  protected $rowDataType = 'Powerform_Google_Service_Sheets_RowData';
  protected $rowDataDataType = 'array';
  protected $rowMetadataType = 'Powerform_Google_Service_Sheets_DimensionProperties';
  protected $rowMetadataDataType = 'array';
  public $startColumn;
  public $startRow;


  public function setColumnMetadata($columnMetadata)
  {
    $this->columnMetadata = $columnMetadata;
  }
  public function getColumnMetadata()
  {
    return $this->columnMetadata;
  }
  public function setRowData($rowData)
  {
    $this->rowData = $rowData;
  }
  public function getRowData()
  {
    return $this->rowData;
  }
  public function setRowMetadata($rowMetadata)
  {
    $this->rowMetadata = $rowMetadata;
  }
  public function getRowMetadata()
  {
    return $this->rowMetadata;
  }
  public function setStartColumn($startColumn)
  {
    $this->startColumn = $startColumn;
  }
  public function getStartColumn()
  {
    return $this->startColumn;
  }
  public function setStartRow($startRow)
  {
    $this->startRow = $startRow;
  }
  public function getStartRow()
  {
    return $this->startRow;
  }
}

class Powerform_Google_Service_Sheets_GridProperties extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $columnCount;
  public $frozenColumnCount;
  public $frozenRowCount;
  public $hideGridlines;
  public $rowCount;


  public function setColumnCount($columnCount)
  {
    $this->columnCount = $columnCount;
  }
  public function getColumnCount()
  {
    return $this->columnCount;
  }
  public function setFrozenColumnCount($frozenColumnCount)
  {
    $this->frozenColumnCount = $frozenColumnCount;
  }
  public function getFrozenColumnCount()
  {
    return $this->frozenColumnCount;
  }
  public function setFrozenRowCount($frozenRowCount)
  {
    $this->frozenRowCount = $frozenRowCount;
  }
  public function getFrozenRowCount()
  {
    return $this->frozenRowCount;
  }
  public function setHideGridlines($hideGridlines)
  {
    $this->hideGridlines = $hideGridlines;
  }
  public function getHideGridlines()
  {
    return $this->hideGridlines;
  }
  public function setRowCount($rowCount)
  {
    $this->rowCount = $rowCount;
  }
  public function getRowCount()
  {
    return $this->rowCount;
  }
}

class Powerform_Google_Service_Sheets_GridRange extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $endColumnIndex;
  public $endRowIndex;
  public $sheetId;
  public $startColumnIndex;
  public $startRowIndex;


  public function setEndColumnIndex($endColumnIndex)
  {
    $this->endColumnIndex = $endColumnIndex;
  }
  public function getEndColumnIndex()
  {
    return $this->endColumnIndex;
  }
  public function setEndRowIndex($endRowIndex)
  {
    $this->endRowIndex = $endRowIndex;
  }
  public function getEndRowIndex()
  {
    return $this->endRowIndex;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
  public function setStartColumnIndex($startColumnIndex)
  {
    $this->startColumnIndex = $startColumnIndex;
  }
  public function getStartColumnIndex()
  {
    return $this->startColumnIndex;
  }
  public function setStartRowIndex($startRowIndex)
  {
    $this->startRowIndex = $startRowIndex;
  }
  public function getStartRowIndex()
  {
    return $this->startRowIndex;
  }
}

class Powerform_Google_Service_Sheets_InsertDimensionRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $inheritFromBefore;
  protected $rangeType = 'Powerform_Google_Service_Sheets_DimensionRange';
  protected $rangeDataType = '';


  public function setInheritFromBefore($inheritFromBefore)
  {
    $this->inheritFromBefore = $inheritFromBefore;
  }
  public function getInheritFromBefore()
  {
    return $this->inheritFromBefore;
  }
  public function setRange(Powerform_Google_Service_Sheets_DimensionRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_InterpolationPoint extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $colorType = 'Powerform_Google_Service_Sheets_Color';
  protected $colorDataType = '';
  public $type;
  public $value;


  public function setColor(Powerform_Google_Service_Sheets_Color $color)
  {
    $this->color = $color;
  }
  public function getColor()
  {
    return $this->color;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
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

class Powerform_Google_Service_Sheets_MergeCellsRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $mergeType;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';


  public function setMergeType($mergeType)
  {
    $this->mergeType = $mergeType;
  }
  public function getMergeType()
  {
    return $this->mergeType;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_MoveDimensionRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $destinationIndex;
  protected $sourceType = 'Powerform_Google_Service_Sheets_DimensionRange';
  protected $sourceDataType = '';


  public function setDestinationIndex($destinationIndex)
  {
    $this->destinationIndex = $destinationIndex;
  }
  public function getDestinationIndex()
  {
    return $this->destinationIndex;
  }
  public function setSource(Powerform_Google_Service_Sheets_DimensionRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Powerform_Google_Service_Sheets_NamedRange extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $name;
  public $namedRangeId;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';


  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setNamedRangeId($namedRangeId)
  {
    $this->namedRangeId = $namedRangeId;
  }
  public function getNamedRangeId()
  {
    return $this->namedRangeId;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_NumberFormat extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $pattern;
  public $type;


  public function setPattern($pattern)
  {
    $this->pattern = $pattern;
  }
  public function getPattern()
  {
    return $this->pattern;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}

class Powerform_Google_Service_Sheets_OverlayPosition extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $anchorCellType = 'Powerform_Google_Service_Sheets_GridCoordinate';
  protected $anchorCellDataType = '';
  public $heightPixels;
  public $offsetXPixels;
  public $offsetYPixels;
  public $widthPixels;


  public function setAnchorCell(Powerform_Google_Service_Sheets_GridCoordinate $anchorCell)
  {
    $this->anchorCell = $anchorCell;
  }
  public function getAnchorCell()
  {
    return $this->anchorCell;
  }
  public function setHeightPixels($heightPixels)
  {
    $this->heightPixels = $heightPixels;
  }
  public function getHeightPixels()
  {
    return $this->heightPixels;
  }
  public function setOffsetXPixels($offsetXPixels)
  {
    $this->offsetXPixels = $offsetXPixels;
  }
  public function getOffsetXPixels()
  {
    return $this->offsetXPixels;
  }
  public function setOffsetYPixels($offsetYPixels)
  {
    $this->offsetYPixels = $offsetYPixels;
  }
  public function getOffsetYPixels()
  {
    return $this->offsetYPixels;
  }
  public function setWidthPixels($widthPixels)
  {
    $this->widthPixels = $widthPixels;
  }
  public function getWidthPixels()
  {
    return $this->widthPixels;
  }
}

class Powerform_Google_Service_Sheets_Padding extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $bottom;
  public $left;
  public $right;
  public $top;


  public function setBottom($bottom)
  {
    $this->bottom = $bottom;
  }
  public function getBottom()
  {
    return $this->bottom;
  }
  public function setLeft($left)
  {
    $this->left = $left;
  }
  public function getLeft()
  {
    return $this->left;
  }
  public function setRight($right)
  {
    $this->right = $right;
  }
  public function getRight()
  {
    return $this->right;
  }
  public function setTop($top)
  {
    $this->top = $top;
  }
  public function getTop()
  {
    return $this->top;
  }
}

class Powerform_Google_Service_Sheets_PasteDataRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $coordinateType = 'Powerform_Google_Service_Sheets_GridCoordinate';
  protected $coordinateDataType = '';
  public $data;
  public $delimiter;
  public $html;
  public $type;


  public function setCoordinate(Powerform_Google_Service_Sheets_GridCoordinate $coordinate)
  {
    $this->coordinate = $coordinate;
  }
  public function getCoordinate()
  {
    return $this->coordinate;
  }
  public function setData($data)
  {
    $this->data = $data;
  }
  public function getData()
  {
    return $this->data;
  }
  public function setDelimiter($delimiter)
  {
    $this->delimiter = $delimiter;
  }
  public function getDelimiter()
  {
    return $this->delimiter;
  }
  public function setHtml($html)
  {
    $this->html = $html;
  }
  public function getHtml()
  {
    return $this->html;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}

class Powerform_Google_Service_Sheets_PieChartSpec extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $domainType = 'Powerform_Google_Service_Sheets_ChartData';
  protected $domainDataType = '';
  public $legendPosition;
  public $pieHole;
  protected $seriesType = 'Powerform_Google_Service_Sheets_ChartData';
  protected $seriesDataType = '';
  public $threeDimensional;


  public function setDomain(Powerform_Google_Service_Sheets_ChartData $domain)
  {
    $this->domain = $domain;
  }
  public function getDomain()
  {
    return $this->domain;
  }
  public function setLegendPosition($legendPosition)
  {
    $this->legendPosition = $legendPosition;
  }
  public function getLegendPosition()
  {
    return $this->legendPosition;
  }
  public function setPieHole($pieHole)
  {
    $this->pieHole = $pieHole;
  }
  public function getPieHole()
  {
    return $this->pieHole;
  }
  public function setSeries(Powerform_Google_Service_Sheets_ChartData $series)
  {
    $this->series = $series;
  }
  public function getSeries()
  {
    return $this->series;
  }
  public function setThreeDimensional($threeDimensional)
  {
    $this->threeDimensional = $threeDimensional;
  }
  public function getThreeDimensional()
  {
    return $this->threeDimensional;
  }
}

class Powerform_Google_Service_Sheets_PivotFilterCriteria extends Powerform_Google_Collection
{
  protected $collection_key = 'visibleValues';
  protected $internal_gapi_mappings = array(
  );
  public $visibleValues;


  public function setVisibleValues($visibleValues)
  {
    $this->visibleValues = $visibleValues;
  }
  public function getVisibleValues()
  {
    return $this->visibleValues;
  }
}

class Powerform_Google_Service_Sheets_PivotGroup extends Powerform_Google_Collection
{
  protected $collection_key = 'valueMetadata';
  protected $internal_gapi_mappings = array(
  );
  public $showTotals;
  public $sortOrder;
  public $sourceColumnOffset;
  protected $valueBucketType = 'Powerform_Google_Service_Sheets_PivotGroupSortValueBucket';
  protected $valueBucketDataType = '';
  protected $valueMetadataType = 'Powerform_Google_Service_Sheets_PivotGroupValueMetadata';
  protected $valueMetadataDataType = 'array';


  public function setShowTotals($showTotals)
  {
    $this->showTotals = $showTotals;
  }
  public function getShowTotals()
  {
    return $this->showTotals;
  }
  public function setSortOrder($sortOrder)
  {
    $this->sortOrder = $sortOrder;
  }
  public function getSortOrder()
  {
    return $this->sortOrder;
  }
  public function setSourceColumnOffset($sourceColumnOffset)
  {
    $this->sourceColumnOffset = $sourceColumnOffset;
  }
  public function getSourceColumnOffset()
  {
    return $this->sourceColumnOffset;
  }
  public function setValueBucket(Powerform_Google_Service_Sheets_PivotGroupSortValueBucket $valueBucket)
  {
    $this->valueBucket = $valueBucket;
  }
  public function getValueBucket()
  {
    return $this->valueBucket;
  }
  public function setValueMetadata($valueMetadata)
  {
    $this->valueMetadata = $valueMetadata;
  }
  public function getValueMetadata()
  {
    return $this->valueMetadata;
  }
}

class Powerform_Google_Service_Sheets_PivotGroupSortValueBucket extends Powerform_Google_Collection
{
  protected $collection_key = 'buckets';
  protected $internal_gapi_mappings = array(
  );
  protected $bucketsType = 'Powerform_Google_Service_Sheets_ExtendedValue';
  protected $bucketsDataType = 'array';
  public $valuesIndex;


  public function setBuckets($buckets)
  {
    $this->buckets = $buckets;
  }
  public function getBuckets()
  {
    return $this->buckets;
  }
  public function setValuesIndex($valuesIndex)
  {
    $this->valuesIndex = $valuesIndex;
  }
  public function getValuesIndex()
  {
    return $this->valuesIndex;
  }
}

class Powerform_Google_Service_Sheets_PivotGroupValueMetadata extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $collapsed;
  protected $valueType = 'Powerform_Google_Service_Sheets_ExtendedValue';
  protected $valueDataType = '';


  public function setCollapsed($collapsed)
  {
    $this->collapsed = $collapsed;
  }
  public function getCollapsed()
  {
    return $this->collapsed;
  }
  public function setValue(Powerform_Google_Service_Sheets_ExtendedValue $value)
  {
    $this->value = $value;
  }
  public function getValue()
  {
    return $this->value;
  }
}

class Powerform_Google_Service_Sheets_PivotTable extends Powerform_Google_Collection
{
  protected $collection_key = 'values';
  protected $internal_gapi_mappings = array(
  );
  protected $columnsType = 'Powerform_Google_Service_Sheets_PivotGroup';
  protected $columnsDataType = 'array';
  protected $criteriaType = 'Powerform_Google_Service_Sheets_PivotFilterCriteria';
  protected $criteriaDataType = 'map';
  protected $rowsType = 'Powerform_Google_Service_Sheets_PivotGroup';
  protected $rowsDataType = 'array';
  protected $sourceType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourceDataType = '';
  public $valueLayout;
  protected $valuesType = 'Powerform_Google_Service_Sheets_PivotValue';
  protected $valuesDataType = 'array';


  public function setColumns($columns)
  {
    $this->columns = $columns;
  }
  public function getColumns()
  {
    return $this->columns;
  }
  public function setCriteria($criteria)
  {
    $this->criteria = $criteria;
  }
  public function getCriteria()
  {
    return $this->criteria;
  }
  public function setRows($rows)
  {
    $this->rows = $rows;
  }
  public function getRows()
  {
    return $this->rows;
  }
  public function setSource(Powerform_Google_Service_Sheets_GridRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
  public function setValueLayout($valueLayout)
  {
    $this->valueLayout = $valueLayout;
  }
  public function getValueLayout()
  {
    return $this->valueLayout;
  }
  public function setValues($values)
  {
    $this->values = $values;
  }
  public function getValues()
  {
    return $this->values;
  }
}

class Powerform_Google_Service_Sheets_PivotValue extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $formula;
  public $name;
  public $sourceColumnOffset;
  public $summarizeFunction;


  public function setFormula($formula)
  {
    $this->formula = $formula;
  }
  public function getFormula()
  {
    return $this->formula;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setSourceColumnOffset($sourceColumnOffset)
  {
    $this->sourceColumnOffset = $sourceColumnOffset;
  }
  public function getSourceColumnOffset()
  {
    return $this->sourceColumnOffset;
  }
  public function setSummarizeFunction($summarizeFunction)
  {
    $this->summarizeFunction = $summarizeFunction;
  }
  public function getSummarizeFunction()
  {
    return $this->summarizeFunction;
  }
}

class Powerform_Google_Service_Sheets_ProtectedRange extends Powerform_Google_Collection
{
  protected $collection_key = 'unprotectedRanges';
  protected $internal_gapi_mappings = array(
  );
  public $description;
  protected $editorsType = 'Powerform_Google_Service_Sheets_Editors';
  protected $editorsDataType = '';
  public $namedRangeId;
  public $protectedRangeId;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  public $requestingUserCanEdit;
  protected $unprotectedRangesType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $unprotectedRangesDataType = 'array';
  public $warningOnly;


  public function setDescription($description)
  {
    $this->description = $description;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function setEditors(Powerform_Google_Service_Sheets_Editors $editors)
  {
    $this->editors = $editors;
  }
  public function getEditors()
  {
    return $this->editors;
  }
  public function setNamedRangeId($namedRangeId)
  {
    $this->namedRangeId = $namedRangeId;
  }
  public function getNamedRangeId()
  {
    return $this->namedRangeId;
  }
  public function setProtectedRangeId($protectedRangeId)
  {
    $this->protectedRangeId = $protectedRangeId;
  }
  public function getProtectedRangeId()
  {
    return $this->protectedRangeId;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setRequestingUserCanEdit($requestingUserCanEdit)
  {
    $this->requestingUserCanEdit = $requestingUserCanEdit;
  }
  public function getRequestingUserCanEdit()
  {
    return $this->requestingUserCanEdit;
  }
  public function setUnprotectedRanges($unprotectedRanges)
  {
    $this->unprotectedRanges = $unprotectedRanges;
  }
  public function getUnprotectedRanges()
  {
    return $this->unprotectedRanges;
  }
  public function setWarningOnly($warningOnly)
  {
    $this->warningOnly = $warningOnly;
  }
  public function getWarningOnly()
  {
    return $this->warningOnly;
  }
}

class Powerform_Google_Service_Sheets_RepeatCellRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $cellType = 'Powerform_Google_Service_Sheets_CellData';
  protected $cellDataType = '';
  public $fields;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';


  public function setCell(Powerform_Google_Service_Sheets_CellData $cell)
  {
    $this->cell = $cell;
  }
  public function getCell()
  {
    return $this->cell;
  }
  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_Request extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $addChartType = 'Powerform_Google_Service_Sheets_AddChartRequest';
  protected $addChartDataType = '';
  protected $addConditionalFormatRuleType = 'Powerform_Google_Service_Sheets_AddConditionalFormatRuleRequest';
  protected $addConditionalFormatRuleDataType = '';
  protected $addFilterViewType = 'Powerform_Google_Service_Sheets_AddFilterViewRequest';
  protected $addFilterViewDataType = '';
  protected $addNamedRangeType = 'Powerform_Google_Service_Sheets_AddNamedRangeRequest';
  protected $addNamedRangeDataType = '';
  protected $addProtectedRangeType = 'Powerform_Google_Service_Sheets_AddProtectedRangeRequest';
  protected $addProtectedRangeDataType = '';
  protected $addSheetType = 'Powerform_Google_Service_Sheets_AddSheetRequest';
  protected $addSheetDataType = '';
  protected $appendCellsType = 'Powerform_Google_Service_Sheets_AppendCellsRequest';
  protected $appendCellsDataType = '';
  protected $appendDimensionType = 'Powerform_Google_Service_Sheets_AppendDimensionRequest';
  protected $appendDimensionDataType = '';
  protected $autoFillType = 'Powerform_Google_Service_Sheets_AutoFillRequest';
  protected $autoFillDataType = '';
  protected $autoResizeDimensionsType = 'Powerform_Google_Service_Sheets_AutoResizeDimensionsRequest';
  protected $autoResizeDimensionsDataType = '';
  protected $clearBasicFilterType = 'Powerform_Google_Service_Sheets_ClearBasicFilterRequest';
  protected $clearBasicFilterDataType = '';
  protected $copyPasteType = 'Powerform_Google_Service_Sheets_CopyPasteRequest';
  protected $copyPasteDataType = '';
  protected $cutPasteType = 'Powerform_Google_Service_Sheets_CutPasteRequest';
  protected $cutPasteDataType = '';
  protected $deleteConditionalFormatRuleType = 'Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleRequest';
  protected $deleteConditionalFormatRuleDataType = '';
  protected $deleteDimensionType = 'Powerform_Google_Service_Sheets_DeleteDimensionRequest';
  protected $deleteDimensionDataType = '';
  protected $deleteEmbeddedObjectType = 'Powerform_Google_Service_Sheets_DeleteEmbeddedObjectRequest';
  protected $deleteEmbeddedObjectDataType = '';
  protected $deleteFilterViewType = 'Powerform_Google_Service_Sheets_DeleteFilterViewRequest';
  protected $deleteFilterViewDataType = '';
  protected $deleteNamedRangeType = 'Powerform_Google_Service_Sheets_DeleteNamedRangeRequest';
  protected $deleteNamedRangeDataType = '';
  protected $deleteProtectedRangeType = 'Powerform_Google_Service_Sheets_DeleteProtectedRangeRequest';
  protected $deleteProtectedRangeDataType = '';
  protected $deleteSheetType = 'Powerform_Google_Service_Sheets_DeleteSheetRequest';
  protected $deleteSheetDataType = '';
  protected $duplicateFilterViewType = 'Powerform_Google_Service_Sheets_DuplicateFilterViewRequest';
  protected $duplicateFilterViewDataType = '';
  protected $duplicateSheetType = 'Powerform_Google_Service_Sheets_DuplicateSheetRequest';
  protected $duplicateSheetDataType = '';
  protected $findReplaceType = 'Powerform_Google_Service_Sheets_FindReplaceRequest';
  protected $findReplaceDataType = '';
  protected $insertDimensionType = 'Powerform_Google_Service_Sheets_InsertDimensionRequest';
  protected $insertDimensionDataType = '';
  protected $mergeCellsType = 'Powerform_Google_Service_Sheets_MergeCellsRequest';
  protected $mergeCellsDataType = '';
  protected $moveDimensionType = 'Powerform_Google_Service_Sheets_MoveDimensionRequest';
  protected $moveDimensionDataType = '';
  protected $pasteDataType = 'Powerform_Google_Service_Sheets_PasteDataRequest';
  protected $pasteDataDataType = '';
  protected $repeatCellType = 'Powerform_Google_Service_Sheets_RepeatCellRequest';
  protected $repeatCellDataType = '';
  protected $setBasicFilterType = 'Powerform_Google_Service_Sheets_SetBasicFilterRequest';
  protected $setBasicFilterDataType = '';
  protected $setDataValidationType = 'Powerform_Google_Service_Sheets_SetDataValidationRequest';
  protected $setDataValidationDataType = '';
  protected $sortRangeType = 'Powerform_Google_Service_Sheets_SortRangeRequest';
  protected $sortRangeDataType = '';
  protected $textToColumnsType = 'Powerform_Google_Service_Sheets_TextToColumnsRequest';
  protected $textToColumnsDataType = '';
  protected $unmergeCellsType = 'Powerform_Google_Service_Sheets_UnmergeCellsRequest';
  protected $unmergeCellsDataType = '';
  protected $updateBordersType = 'Powerform_Google_Service_Sheets_UpdateBordersRequest';
  protected $updateBordersDataType = '';
  protected $updateCellsType = 'Powerform_Google_Service_Sheets_UpdateCellsRequest';
  protected $updateCellsDataType = '';
  protected $updateChartSpecType = 'Powerform_Google_Service_Sheets_UpdateChartSpecRequest';
  protected $updateChartSpecDataType = '';
  protected $updateConditionalFormatRuleType = 'Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleRequest';
  protected $updateConditionalFormatRuleDataType = '';
  protected $updateDimensionPropertiesType = 'Powerform_Google_Service_Sheets_UpdateDimensionPropertiesRequest';
  protected $updateDimensionPropertiesDataType = '';
  protected $updateEmbeddedObjectPositionType = 'Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionRequest';
  protected $updateEmbeddedObjectPositionDataType = '';
  protected $updateFilterViewType = 'Powerform_Google_Service_Sheets_UpdateFilterViewRequest';
  protected $updateFilterViewDataType = '';
  protected $updateNamedRangeType = 'Powerform_Google_Service_Sheets_UpdateNamedRangeRequest';
  protected $updateNamedRangeDataType = '';
  protected $updateProtectedRangeType = 'Powerform_Google_Service_Sheets_UpdateProtectedRangeRequest';
  protected $updateProtectedRangeDataType = '';
  protected $updateSheetPropertiesType = 'Powerform_Google_Service_Sheets_UpdateSheetPropertiesRequest';
  protected $updateSheetPropertiesDataType = '';
  protected $updateSpreadsheetPropertiesType = 'Powerform_Google_Service_Sheets_UpdateSpreadsheetPropertiesRequest';
  protected $updateSpreadsheetPropertiesDataType = '';


  public function setAddChart(Powerform_Google_Service_Sheets_AddChartRequest $addChart)
  {
    $this->addChart = $addChart;
  }
  public function getAddChart()
  {
    return $this->addChart;
  }
  public function setAddConditionalFormatRule(Powerform_Google_Service_Sheets_AddConditionalFormatRuleRequest $addConditionalFormatRule)
  {
    $this->addConditionalFormatRule = $addConditionalFormatRule;
  }
  public function getAddConditionalFormatRule()
  {
    return $this->addConditionalFormatRule;
  }
  public function setAddFilterView(Powerform_Google_Service_Sheets_AddFilterViewRequest $addFilterView)
  {
    $this->addFilterView = $addFilterView;
  }
  public function getAddFilterView()
  {
    return $this->addFilterView;
  }
  public function setAddNamedRange(Powerform_Google_Service_Sheets_AddNamedRangeRequest $addNamedRange)
  {
    $this->addNamedRange = $addNamedRange;
  }
  public function getAddNamedRange()
  {
    return $this->addNamedRange;
  }
  public function setAddProtectedRange(Powerform_Google_Service_Sheets_AddProtectedRangeRequest $addProtectedRange)
  {
    $this->addProtectedRange = $addProtectedRange;
  }
  public function getAddProtectedRange()
  {
    return $this->addProtectedRange;
  }
  public function setAddSheet(Powerform_Google_Service_Sheets_AddSheetRequest $addSheet)
  {
    $this->addSheet = $addSheet;
  }
  public function getAddSheet()
  {
    return $this->addSheet;
  }
  public function setAppendCells(Powerform_Google_Service_Sheets_AppendCellsRequest $appendCells)
  {
    $this->appendCells = $appendCells;
  }
  public function getAppendCells()
  {
    return $this->appendCells;
  }
  public function setAppendDimension(Powerform_Google_Service_Sheets_AppendDimensionRequest $appendDimension)
  {
    $this->appendDimension = $appendDimension;
  }
  public function getAppendDimension()
  {
    return $this->appendDimension;
  }
  public function setAutoFill(Powerform_Google_Service_Sheets_AutoFillRequest $autoFill)
  {
    $this->autoFill = $autoFill;
  }
  public function getAutoFill()
  {
    return $this->autoFill;
  }
  public function setAutoResizeDimensions(Powerform_Google_Service_Sheets_AutoResizeDimensionsRequest $autoResizeDimensions)
  {
    $this->autoResizeDimensions = $autoResizeDimensions;
  }
  public function getAutoResizeDimensions()
  {
    return $this->autoResizeDimensions;
  }
  public function setClearBasicFilter(Powerform_Google_Service_Sheets_ClearBasicFilterRequest $clearBasicFilter)
  {
    $this->clearBasicFilter = $clearBasicFilter;
  }
  public function getClearBasicFilter()
  {
    return $this->clearBasicFilter;
  }
  public function setCopyPaste(Powerform_Google_Service_Sheets_CopyPasteRequest $copyPaste)
  {
    $this->copyPaste = $copyPaste;
  }
  public function getCopyPaste()
  {
    return $this->copyPaste;
  }
  public function setCutPaste(Powerform_Google_Service_Sheets_CutPasteRequest $cutPaste)
  {
    $this->cutPaste = $cutPaste;
  }
  public function getCutPaste()
  {
    return $this->cutPaste;
  }
  public function setDeleteConditionalFormatRule(Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleRequest $deleteConditionalFormatRule)
  {
    $this->deleteConditionalFormatRule = $deleteConditionalFormatRule;
  }
  public function getDeleteConditionalFormatRule()
  {
    return $this->deleteConditionalFormatRule;
  }
  public function setDeleteDimension(Powerform_Google_Service_Sheets_DeleteDimensionRequest $deleteDimension)
  {
    $this->deleteDimension = $deleteDimension;
  }
  public function getDeleteDimension()
  {
    return $this->deleteDimension;
  }
  public function setDeleteEmbeddedObject(Powerform_Google_Service_Sheets_DeleteEmbeddedObjectRequest $deleteEmbeddedObject)
  {
    $this->deleteEmbeddedObject = $deleteEmbeddedObject;
  }
  public function getDeleteEmbeddedObject()
  {
    return $this->deleteEmbeddedObject;
  }
  public function setDeleteFilterView(Powerform_Google_Service_Sheets_DeleteFilterViewRequest $deleteFilterView)
  {
    $this->deleteFilterView = $deleteFilterView;
  }
  public function getDeleteFilterView()
  {
    return $this->deleteFilterView;
  }
  public function setDeleteNamedRange(Powerform_Google_Service_Sheets_DeleteNamedRangeRequest $deleteNamedRange)
  {
    $this->deleteNamedRange = $deleteNamedRange;
  }
  public function getDeleteNamedRange()
  {
    return $this->deleteNamedRange;
  }
  public function setDeleteProtectedRange(Powerform_Google_Service_Sheets_DeleteProtectedRangeRequest $deleteProtectedRange)
  {
    $this->deleteProtectedRange = $deleteProtectedRange;
  }
  public function getDeleteProtectedRange()
  {
    return $this->deleteProtectedRange;
  }
  public function setDeleteSheet(Powerform_Google_Service_Sheets_DeleteSheetRequest $deleteSheet)
  {
    $this->deleteSheet = $deleteSheet;
  }
  public function getDeleteSheet()
  {
    return $this->deleteSheet;
  }
  public function setDuplicateFilterView(Powerform_Google_Service_Sheets_DuplicateFilterViewRequest $duplicateFilterView)
  {
    $this->duplicateFilterView = $duplicateFilterView;
  }
  public function getDuplicateFilterView()
  {
    return $this->duplicateFilterView;
  }
  public function setDuplicateSheet(Powerform_Google_Service_Sheets_DuplicateSheetRequest $duplicateSheet)
  {
    $this->duplicateSheet = $duplicateSheet;
  }
  public function getDuplicateSheet()
  {
    return $this->duplicateSheet;
  }
  public function setFindReplace(Powerform_Google_Service_Sheets_FindReplaceRequest $findReplace)
  {
    $this->findReplace = $findReplace;
  }
  public function getFindReplace()
  {
    return $this->findReplace;
  }
  public function setInsertDimension(Powerform_Google_Service_Sheets_InsertDimensionRequest $insertDimension)
  {
    $this->insertDimension = $insertDimension;
  }
  public function getInsertDimension()
  {
    return $this->insertDimension;
  }
  public function setMergeCells(Powerform_Google_Service_Sheets_MergeCellsRequest $mergeCells)
  {
    $this->mergeCells = $mergeCells;
  }
  public function getMergeCells()
  {
    return $this->mergeCells;
  }
  public function setMoveDimension(Powerform_Google_Service_Sheets_MoveDimensionRequest $moveDimension)
  {
    $this->moveDimension = $moveDimension;
  }
  public function getMoveDimension()
  {
    return $this->moveDimension;
  }
  public function setPasteData(Powerform_Google_Service_Sheets_PasteDataRequest $pasteData)
  {
    $this->pasteData = $pasteData;
  }
  public function getPasteData()
  {
    return $this->pasteData;
  }
  public function setRepeatCell(Powerform_Google_Service_Sheets_RepeatCellRequest $repeatCell)
  {
    $this->repeatCell = $repeatCell;
  }
  public function getRepeatCell()
  {
    return $this->repeatCell;
  }
  public function setSetBasicFilter(Powerform_Google_Service_Sheets_SetBasicFilterRequest $setBasicFilter)
  {
    $this->setBasicFilter = $setBasicFilter;
  }
  public function getSetBasicFilter()
  {
    return $this->setBasicFilter;
  }
  public function setSetDataValidation(Powerform_Google_Service_Sheets_SetDataValidationRequest $setDataValidation)
  {
    $this->setDataValidation = $setDataValidation;
  }
  public function getSetDataValidation()
  {
    return $this->setDataValidation;
  }
  public function setSortRange(Powerform_Google_Service_Sheets_SortRangeRequest $sortRange)
  {
    $this->sortRange = $sortRange;
  }
  public function getSortRange()
  {
    return $this->sortRange;
  }
  public function setTextToColumns(Powerform_Google_Service_Sheets_TextToColumnsRequest $textToColumns)
  {
    $this->textToColumns = $textToColumns;
  }
  public function getTextToColumns()
  {
    return $this->textToColumns;
  }
  public function setUnmergeCells(Powerform_Google_Service_Sheets_UnmergeCellsRequest $unmergeCells)
  {
    $this->unmergeCells = $unmergeCells;
  }
  public function getUnmergeCells()
  {
    return $this->unmergeCells;
  }
  public function setUpdateBorders(Powerform_Google_Service_Sheets_UpdateBordersRequest $updateBorders)
  {
    $this->updateBorders = $updateBorders;
  }
  public function getUpdateBorders()
  {
    return $this->updateBorders;
  }
  public function setUpdateCells(Powerform_Google_Service_Sheets_UpdateCellsRequest $updateCells)
  {
    $this->updateCells = $updateCells;
  }
  public function getUpdateCells()
  {
    return $this->updateCells;
  }
  public function setUpdateChartSpec(Powerform_Google_Service_Sheets_UpdateChartSpecRequest $updateChartSpec)
  {
    $this->updateChartSpec = $updateChartSpec;
  }
  public function getUpdateChartSpec()
  {
    return $this->updateChartSpec;
  }
  public function setUpdateConditionalFormatRule(Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleRequest $updateConditionalFormatRule)
  {
    $this->updateConditionalFormatRule = $updateConditionalFormatRule;
  }
  public function getUpdateConditionalFormatRule()
  {
    return $this->updateConditionalFormatRule;
  }
  public function setUpdateDimensionProperties(Powerform_Google_Service_Sheets_UpdateDimensionPropertiesRequest $updateDimensionProperties)
  {
    $this->updateDimensionProperties = $updateDimensionProperties;
  }
  public function getUpdateDimensionProperties()
  {
    return $this->updateDimensionProperties;
  }
  public function setUpdateEmbeddedObjectPosition(Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionRequest $updateEmbeddedObjectPosition)
  {
    $this->updateEmbeddedObjectPosition = $updateEmbeddedObjectPosition;
  }
  public function getUpdateEmbeddedObjectPosition()
  {
    return $this->updateEmbeddedObjectPosition;
  }
  public function setUpdateFilterView(Powerform_Google_Service_Sheets_UpdateFilterViewRequest $updateFilterView)
  {
    $this->updateFilterView = $updateFilterView;
  }
  public function getUpdateFilterView()
  {
    return $this->updateFilterView;
  }
  public function setUpdateNamedRange(Powerform_Google_Service_Sheets_UpdateNamedRangeRequest $updateNamedRange)
  {
    $this->updateNamedRange = $updateNamedRange;
  }
  public function getUpdateNamedRange()
  {
    return $this->updateNamedRange;
  }
  public function setUpdateProtectedRange(Powerform_Google_Service_Sheets_UpdateProtectedRangeRequest $updateProtectedRange)
  {
    $this->updateProtectedRange = $updateProtectedRange;
  }
  public function getUpdateProtectedRange()
  {
    return $this->updateProtectedRange;
  }
  public function setUpdateSheetProperties(Powerform_Google_Service_Sheets_UpdateSheetPropertiesRequest $updateSheetProperties)
  {
    $this->updateSheetProperties = $updateSheetProperties;
  }
  public function getUpdateSheetProperties()
  {
    return $this->updateSheetProperties;
  }
  public function setUpdateSpreadsheetProperties(Powerform_Google_Service_Sheets_UpdateSpreadsheetPropertiesRequest $updateSpreadsheetProperties)
  {
    $this->updateSpreadsheetProperties = $updateSpreadsheetProperties;
  }
  public function getUpdateSpreadsheetProperties()
  {
    return $this->updateSpreadsheetProperties;
  }
}

class Powerform_Google_Service_Sheets_Response extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $addChartType = 'Powerform_Google_Service_Sheets_AddChartResponse';
  protected $addChartDataType = '';
  protected $addFilterViewType = 'Powerform_Google_Service_Sheets_AddFilterViewResponse';
  protected $addFilterViewDataType = '';
  protected $addNamedRangeType = 'Powerform_Google_Service_Sheets_AddNamedRangeResponse';
  protected $addNamedRangeDataType = '';
  protected $addProtectedRangeType = 'Powerform_Google_Service_Sheets_AddProtectedRangeResponse';
  protected $addProtectedRangeDataType = '';
  protected $addSheetType = 'Powerform_Google_Service_Sheets_AddSheetResponse';
  protected $addSheetDataType = '';
  protected $deleteConditionalFormatRuleType = 'Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleResponse';
  protected $deleteConditionalFormatRuleDataType = '';
  protected $duplicateFilterViewType = 'Powerform_Google_Service_Sheets_DuplicateFilterViewResponse';
  protected $duplicateFilterViewDataType = '';
  protected $duplicateSheetType = 'Powerform_Google_Service_Sheets_DuplicateSheetResponse';
  protected $duplicateSheetDataType = '';
  protected $findReplaceType = 'Powerform_Google_Service_Sheets_FindReplaceResponse';
  protected $findReplaceDataType = '';
  protected $updateConditionalFormatRuleType = 'Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleResponse';
  protected $updateConditionalFormatRuleDataType = '';
  protected $updateEmbeddedObjectPositionType = 'Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionResponse';
  protected $updateEmbeddedObjectPositionDataType = '';


  public function setAddChart(Powerform_Google_Service_Sheets_AddChartResponse $addChart)
  {
    $this->addChart = $addChart;
  }
  public function getAddChart()
  {
    return $this->addChart;
  }
  public function setAddFilterView(Powerform_Google_Service_Sheets_AddFilterViewResponse $addFilterView)
  {
    $this->addFilterView = $addFilterView;
  }
  public function getAddFilterView()
  {
    return $this->addFilterView;
  }
  public function setAddNamedRange(Powerform_Google_Service_Sheets_AddNamedRangeResponse $addNamedRange)
  {
    $this->addNamedRange = $addNamedRange;
  }
  public function getAddNamedRange()
  {
    return $this->addNamedRange;
  }
  public function setAddProtectedRange(Powerform_Google_Service_Sheets_AddProtectedRangeResponse $addProtectedRange)
  {
    $this->addProtectedRange = $addProtectedRange;
  }
  public function getAddProtectedRange()
  {
    return $this->addProtectedRange;
  }
  public function setAddSheet(Powerform_Google_Service_Sheets_AddSheetResponse $addSheet)
  {
    $this->addSheet = $addSheet;
  }
  public function getAddSheet()
  {
    return $this->addSheet;
  }
  public function setDeleteConditionalFormatRule(Powerform_Google_Service_Sheets_DeleteConditionalFormatRuleResponse $deleteConditionalFormatRule)
  {
    $this->deleteConditionalFormatRule = $deleteConditionalFormatRule;
  }
  public function getDeleteConditionalFormatRule()
  {
    return $this->deleteConditionalFormatRule;
  }
  public function setDuplicateFilterView(Powerform_Google_Service_Sheets_DuplicateFilterViewResponse $duplicateFilterView)
  {
    $this->duplicateFilterView = $duplicateFilterView;
  }
  public function getDuplicateFilterView()
  {
    return $this->duplicateFilterView;
  }
  public function setDuplicateSheet(Powerform_Google_Service_Sheets_DuplicateSheetResponse $duplicateSheet)
  {
    $this->duplicateSheet = $duplicateSheet;
  }
  public function getDuplicateSheet()
  {
    return $this->duplicateSheet;
  }
  public function setFindReplace(Powerform_Google_Service_Sheets_FindReplaceResponse $findReplace)
  {
    $this->findReplace = $findReplace;
  }
  public function getFindReplace()
  {
    return $this->findReplace;
  }
  public function setUpdateConditionalFormatRule(Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleResponse $updateConditionalFormatRule)
  {
    $this->updateConditionalFormatRule = $updateConditionalFormatRule;
  }
  public function getUpdateConditionalFormatRule()
  {
    return $this->updateConditionalFormatRule;
  }
  public function setUpdateEmbeddedObjectPosition(Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionResponse $updateEmbeddedObjectPosition)
  {
    $this->updateEmbeddedObjectPosition = $updateEmbeddedObjectPosition;
  }
  public function getUpdateEmbeddedObjectPosition()
  {
    return $this->updateEmbeddedObjectPosition;
  }
}

class Powerform_Google_Service_Sheets_RowData extends Powerform_Google_Collection
{
  protected $collection_key = 'values';
  protected $internal_gapi_mappings = array(
  );
  protected $valuesType = 'Powerform_Google_Service_Sheets_CellData';
  protected $valuesDataType = 'array';


  public function setValues($values)
  {
    $this->values = $values;
  }
  public function getValues()
  {
    return $this->values;
  }
}

class Powerform_Google_Service_Sheets_SetBasicFilterRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $filterType = 'Powerform_Google_Service_Sheets_BasicFilter';
  protected $filterDataType = '';


  public function setFilter(Powerform_Google_Service_Sheets_BasicFilter $filter)
  {
    $this->filter = $filter;
  }
  public function getFilter()
  {
    return $this->filter;
  }
}

class Powerform_Google_Service_Sheets_SetDataValidationRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $ruleType = 'Powerform_Google_Service_Sheets_DataValidationRule';
  protected $ruleDataType = '';


  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setRule(Powerform_Google_Service_Sheets_DataValidationRule $rule)
  {
    $this->rule = $rule;
  }
  public function getRule()
  {
    return $this->rule;
  }
}

class Powerform_Google_Service_Sheets_Sheet extends Powerform_Google_Collection
{
  protected $collection_key = 'protectedRanges';
  protected $internal_gapi_mappings = array(
  );
  protected $basicFilterType = 'Powerform_Google_Service_Sheets_BasicFilter';
  protected $basicFilterDataType = '';
  protected $chartsType = 'Powerform_Google_Service_Sheets_EmbeddedChart';
  protected $chartsDataType = 'array';
  protected $conditionalFormatsType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $conditionalFormatsDataType = 'array';
  protected $dataType = 'Powerform_Google_Service_Sheets_GridData';
  protected $dataDataType = 'array';
  protected $filterViewsType = 'Powerform_Google_Service_Sheets_FilterView';
  protected $filterViewsDataType = 'array';
  protected $mergesType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $mergesDataType = 'array';
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SheetProperties';
  protected $propertiesDataType = '';
  protected $protectedRangesType = 'Powerform_Google_Service_Sheets_ProtectedRange';
  protected $protectedRangesDataType = 'array';


  public function setBasicFilter(Powerform_Google_Service_Sheets_BasicFilter $basicFilter)
  {
    $this->basicFilter = $basicFilter;
  }
  public function getBasicFilter()
  {
    return $this->basicFilter;
  }
  public function setCharts($charts)
  {
    $this->charts = $charts;
  }
  public function getCharts()
  {
    return $this->charts;
  }
  public function setConditionalFormats($conditionalFormats)
  {
    $this->conditionalFormats = $conditionalFormats;
  }
  public function getConditionalFormats()
  {
    return $this->conditionalFormats;
  }
  public function setData($data)
  {
    $this->data = $data;
  }
  public function getData()
  {
    return $this->data;
  }
  public function setFilterViews($filterViews)
  {
    $this->filterViews = $filterViews;
  }
  public function getFilterViews()
  {
    return $this->filterViews;
  }
  public function setMerges($merges)
  {
    $this->merges = $merges;
  }
  public function getMerges()
  {
    return $this->merges;
  }
  public function setProperties(Powerform_Google_Service_Sheets_SheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
  public function setProtectedRanges($protectedRanges)
  {
    $this->protectedRanges = $protectedRanges;
  }
  public function getProtectedRanges()
  {
    return $this->protectedRanges;
  }
}

class Powerform_Google_Service_Sheets_SheetProperties extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $gridPropertiesType = 'Powerform_Google_Service_Sheets_GridProperties';
  protected $gridPropertiesDataType = '';
  public $hidden;
  public $index;
  public $rightToLeft;
  public $sheetId;
  public $sheetType;
  protected $tabColorType = 'Powerform_Google_Service_Sheets_Color';
  protected $tabColorDataType = '';
  public $title;


  public function setGridProperties(Powerform_Google_Service_Sheets_GridProperties $gridProperties)
  {
    $this->gridProperties = $gridProperties;
  }
  public function getGridProperties()
  {
    return $this->gridProperties;
  }
  public function setHidden($hidden)
  {
    $this->hidden = $hidden;
  }
  public function getHidden()
  {
    return $this->hidden;
  }
  public function setIndex($index)
  {
    $this->index = $index;
  }
  public function getIndex()
  {
    return $this->index;
  }
  public function setRightToLeft($rightToLeft)
  {
    $this->rightToLeft = $rightToLeft;
  }
  public function getRightToLeft()
  {
    return $this->rightToLeft;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
  public function setSheetType($sheetType)
  {
    $this->sheetType = $sheetType;
  }
  public function getSheetType()
  {
    return $this->sheetType;
  }
  public function setTabColor(Powerform_Google_Service_Sheets_Color $tabColor)
  {
    $this->tabColor = $tabColor;
  }
  public function getTabColor()
  {
    return $this->tabColor;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getTitle()
  {
    return $this->title;
  }
}

class Powerform_Google_Service_Sheets_SortRangeRequest extends Powerform_Google_Collection
{
  protected $collection_key = 'sortSpecs';
  protected $internal_gapi_mappings = array(
  );
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $sortSpecsType = 'Powerform_Google_Service_Sheets_SortSpec';
  protected $sortSpecsDataType = 'array';


  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setSortSpecs($sortSpecs)
  {
    $this->sortSpecs = $sortSpecs;
  }
  public function getSortSpecs()
  {
    return $this->sortSpecs;
  }
}

class Powerform_Google_Service_Sheets_SortSpec extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $dimensionIndex;
  public $sortOrder;


  public function setDimensionIndex($dimensionIndex)
  {
    $this->dimensionIndex = $dimensionIndex;
  }
  public function getDimensionIndex()
  {
    return $this->dimensionIndex;
  }
  public function setSortOrder($sortOrder)
  {
    $this->sortOrder = $sortOrder;
  }
  public function getSortOrder()
  {
    return $this->sortOrder;
  }
}

class Powerform_Google_Service_Sheets_SourceAndDestination extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $dimension;
  public $fillLength;
  protected $sourceType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourceDataType = '';


  public function setDimension($dimension)
  {
    $this->dimension = $dimension;
  }
  public function getDimension()
  {
    return $this->dimension;
  }
  public function setFillLength($fillLength)
  {
    $this->fillLength = $fillLength;
  }
  public function getFillLength()
  {
    return $this->fillLength;
  }
  public function setSource(Powerform_Google_Service_Sheets_GridRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Powerform_Google_Service_Sheets_Spreadsheet extends Powerform_Google_Collection
{
  protected $collection_key = 'sheets';
  protected $internal_gapi_mappings = array(
  );
  protected $namedRangesType = 'Powerform_Google_Service_Sheets_NamedRange';
  protected $namedRangesDataType = 'array';
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SpreadsheetProperties';
  protected $propertiesDataType = '';
  protected $sheetsType = 'Powerform_Google_Service_Sheets_Sheet';
  protected $sheetsDataType = 'array';
  public $spreadsheetId;


  public function setNamedRanges($namedRanges)
  {
    $this->namedRanges = $namedRanges;
  }
  public function getNamedRanges()
  {
    return $this->namedRanges;
  }
  public function setProperties(Powerform_Google_Service_Sheets_SpreadsheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
  public function setSheets($sheets)
  {
    $this->sheets = $sheets;
  }
  public function getSheets()
  {
    return $this->sheets;
  }
  public function setSpreadsheetId($spreadsheetId)
  {
    $this->spreadsheetId = $spreadsheetId;
  }
  public function getSpreadsheetId()
  {
    return $this->spreadsheetId;
  }
}

class Powerform_Google_Service_Sheets_SpreadsheetProperties extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $autoRecalc;
  protected $defaultFormatType = 'Powerform_Google_Service_Sheets_CellFormat';
  protected $defaultFormatDataType = '';
  public $locale;
  public $timeZone;
  public $title;


  public function setAutoRecalc($autoRecalc)
  {
    $this->autoRecalc = $autoRecalc;
  }
  public function getAutoRecalc()
  {
    return $this->autoRecalc;
  }
  public function setDefaultFormat(Powerform_Google_Service_Sheets_CellFormat $defaultFormat)
  {
    $this->defaultFormat = $defaultFormat;
  }
  public function getDefaultFormat()
  {
    return $this->defaultFormat;
  }
  public function setLocale($locale)
  {
    $this->locale = $locale;
  }
  public function getLocale()
  {
    return $this->locale;
  }
  public function setTimeZone($timeZone)
  {
    $this->timeZone = $timeZone;
  }
  public function getTimeZone()
  {
    return $this->timeZone;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getTitle()
  {
    return $this->title;
  }
}

class Powerform_Google_Service_Sheets_TextFormat extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $bold;
  public $fontFamily;
  public $fontSize;
  protected $foregroundColorType = 'Powerform_Google_Service_Sheets_Color';
  protected $foregroundColorDataType = '';
  public $italic;
  public $strikethrough;
  public $underline;


  public function setBold($bold)
  {
    $this->bold = $bold;
  }
  public function getBold()
  {
    return $this->bold;
  }
  public function setFontFamily($fontFamily)
  {
    $this->fontFamily = $fontFamily;
  }
  public function getFontFamily()
  {
    return $this->fontFamily;
  }
  public function setFontSize($fontSize)
  {
    $this->fontSize = $fontSize;
  }
  public function getFontSize()
  {
    return $this->fontSize;
  }
  public function setForegroundColor(Powerform_Google_Service_Sheets_Color $foregroundColor)
  {
    $this->foregroundColor = $foregroundColor;
  }
  public function getForegroundColor()
  {
    return $this->foregroundColor;
  }
  public function setItalic($italic)
  {
    $this->italic = $italic;
  }
  public function getItalic()
  {
    return $this->italic;
  }
  public function setStrikethrough($strikethrough)
  {
    $this->strikethrough = $strikethrough;
  }
  public function getStrikethrough()
  {
    return $this->strikethrough;
  }
  public function setUnderline($underline)
  {
    $this->underline = $underline;
  }
  public function getUnderline()
  {
    return $this->underline;
  }
}

class Powerform_Google_Service_Sheets_TextFormatRun extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $formatType = 'Powerform_Google_Service_Sheets_TextFormat';
  protected $formatDataType = '';
  public $startIndex;


  public function setFormat(Powerform_Google_Service_Sheets_TextFormat $format)
  {
    $this->format = $format;
  }
  public function getFormat()
  {
    return $this->format;
  }
  public function setStartIndex($startIndex)
  {
    $this->startIndex = $startIndex;
  }
  public function getStartIndex()
  {
    return $this->startIndex;
  }
}

class Powerform_Google_Service_Sheets_TextToColumnsRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $delimiter;
  public $delimiterType;
  protected $sourceType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $sourceDataType = '';


  public function setDelimiter($delimiter)
  {
    $this->delimiter = $delimiter;
  }
  public function getDelimiter()
  {
    return $this->delimiter;
  }
  public function setDelimiterType($delimiterType)
  {
    $this->delimiterType = $delimiterType;
  }
  public function getDelimiterType()
  {
    return $this->delimiterType;
  }
  public function setSource(Powerform_Google_Service_Sheets_GridRange $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Powerform_Google_Service_Sheets_UnmergeCellsRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';


  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_UpdateBordersRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $bottomType = 'Powerform_Google_Service_Sheets_Border';
  protected $bottomDataType = '';
  protected $innerHorizontalType = 'Powerform_Google_Service_Sheets_Border';
  protected $innerHorizontalDataType = '';
  protected $innerVerticalType = 'Powerform_Google_Service_Sheets_Border';
  protected $innerVerticalDataType = '';
  protected $leftType = 'Powerform_Google_Service_Sheets_Border';
  protected $leftDataType = '';
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $rightType = 'Powerform_Google_Service_Sheets_Border';
  protected $rightDataType = '';
  protected $topType = 'Powerform_Google_Service_Sheets_Border';
  protected $topDataType = '';


  public function setBottom(Powerform_Google_Service_Sheets_Border $bottom)
  {
    $this->bottom = $bottom;
  }
  public function getBottom()
  {
    return $this->bottom;
  }
  public function setInnerHorizontal(Powerform_Google_Service_Sheets_Border $innerHorizontal)
  {
    $this->innerHorizontal = $innerHorizontal;
  }
  public function getInnerHorizontal()
  {
    return $this->innerHorizontal;
  }
  public function setInnerVertical(Powerform_Google_Service_Sheets_Border $innerVertical)
  {
    $this->innerVertical = $innerVertical;
  }
  public function getInnerVertical()
  {
    return $this->innerVertical;
  }
  public function setLeft(Powerform_Google_Service_Sheets_Border $left)
  {
    $this->left = $left;
  }
  public function getLeft()
  {
    return $this->left;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setRight(Powerform_Google_Service_Sheets_Border $right)
  {
    $this->right = $right;
  }
  public function getRight()
  {
    return $this->right;
  }
  public function setTop(Powerform_Google_Service_Sheets_Border $top)
  {
    $this->top = $top;
  }
  public function getTop()
  {
    return $this->top;
  }
}

class Powerform_Google_Service_Sheets_UpdateCellsRequest extends Powerform_Google_Collection
{
  protected $collection_key = 'rows';
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $rangeType = 'Powerform_Google_Service_Sheets_GridRange';
  protected $rangeDataType = '';
  protected $rowsType = 'Powerform_Google_Service_Sheets_RowData';
  protected $rowsDataType = 'array';
  protected $startType = 'Powerform_Google_Service_Sheets_GridCoordinate';
  protected $startDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setRange(Powerform_Google_Service_Sheets_GridRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setRows($rows)
  {
    $this->rows = $rows;
  }
  public function getRows()
  {
    return $this->rows;
  }
  public function setStart(Powerform_Google_Service_Sheets_GridCoordinate $start)
  {
    $this->start = $start;
  }
  public function getStart()
  {
    return $this->start;
  }
}

class Powerform_Google_Service_Sheets_UpdateChartSpecRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $chartId;
  protected $specType = 'Powerform_Google_Service_Sheets_ChartSpec';
  protected $specDataType = '';


  public function setChartId($chartId)
  {
    $this->chartId = $chartId;
  }
  public function getChartId()
  {
    return $this->chartId;
  }
  public function setSpec(Powerform_Google_Service_Sheets_ChartSpec $spec)
  {
    $this->spec = $spec;
  }
  public function getSpec()
  {
    return $this->spec;
  }
}

class Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $index;
  public $newIndex;
  protected $ruleType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $ruleDataType = '';
  public $sheetId;


  public function setIndex($index)
  {
    $this->index = $index;
  }
  public function getIndex()
  {
    return $this->index;
  }
  public function setNewIndex($newIndex)
  {
    $this->newIndex = $newIndex;
  }
  public function getNewIndex()
  {
    return $this->newIndex;
  }
  public function setRule(Powerform_Google_Service_Sheets_ConditionalFormatRule $rule)
  {
    $this->rule = $rule;
  }
  public function getRule()
  {
    return $this->rule;
  }
  public function setSheetId($sheetId)
  {
    $this->sheetId = $sheetId;
  }
  public function getSheetId()
  {
    return $this->sheetId;
  }
}

class Powerform_Google_Service_Sheets_UpdateConditionalFormatRuleResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $newIndex;
  protected $newRuleType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $newRuleDataType = '';
  public $oldIndex;
  protected $oldRuleType = 'Powerform_Google_Service_Sheets_ConditionalFormatRule';
  protected $oldRuleDataType = '';


  public function setNewIndex($newIndex)
  {
    $this->newIndex = $newIndex;
  }
  public function getNewIndex()
  {
    return $this->newIndex;
  }
  public function setNewRule(Powerform_Google_Service_Sheets_ConditionalFormatRule $newRule)
  {
    $this->newRule = $newRule;
  }
  public function getNewRule()
  {
    return $this->newRule;
  }
  public function setOldIndex($oldIndex)
  {
    $this->oldIndex = $oldIndex;
  }
  public function getOldIndex()
  {
    return $this->oldIndex;
  }
  public function setOldRule(Powerform_Google_Service_Sheets_ConditionalFormatRule $oldRule)
  {
    $this->oldRule = $oldRule;
  }
  public function getOldRule()
  {
    return $this->oldRule;
  }
}

class Powerform_Google_Service_Sheets_UpdateDimensionPropertiesRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $propertiesType = 'Powerform_Google_Service_Sheets_DimensionProperties';
  protected $propertiesDataType = '';
  protected $rangeType = 'Powerform_Google_Service_Sheets_DimensionRange';
  protected $rangeDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setProperties(Powerform_Google_Service_Sheets_DimensionProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
  public function setRange(Powerform_Google_Service_Sheets_DimensionRange $range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
}

class Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $newPositionType = 'Powerform_Google_Service_Sheets_EmbeddedObjectPosition';
  protected $newPositionDataType = '';
  public $objectId;


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setNewPosition(Powerform_Google_Service_Sheets_EmbeddedObjectPosition $newPosition)
  {
    $this->newPosition = $newPosition;
  }
  public function getNewPosition()
  {
    return $this->newPosition;
  }
  public function setObjectId($objectId)
  {
    $this->objectId = $objectId;
  }
  public function getObjectId()
  {
    return $this->objectId;
  }
}

class Powerform_Google_Service_Sheets_UpdateEmbeddedObjectPositionResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $positionType = 'Powerform_Google_Service_Sheets_EmbeddedObjectPosition';
  protected $positionDataType = '';


  public function setPosition(Powerform_Google_Service_Sheets_EmbeddedObjectPosition $position)
  {
    $this->position = $position;
  }
  public function getPosition()
  {
    return $this->position;
  }
}

class Powerform_Google_Service_Sheets_UpdateFilterViewRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $filterType = 'Powerform_Google_Service_Sheets_FilterView';
  protected $filterDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setFilter(Powerform_Google_Service_Sheets_FilterView $filter)
  {
    $this->filter = $filter;
  }
  public function getFilter()
  {
    return $this->filter;
  }
}

class Powerform_Google_Service_Sheets_UpdateNamedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $namedRangeType = 'Powerform_Google_Service_Sheets_NamedRange';
  protected $namedRangeDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setNamedRange(Powerform_Google_Service_Sheets_NamedRange $namedRange)
  {
    $this->namedRange = $namedRange;
  }
  public function getNamedRange()
  {
    return $this->namedRange;
  }
}

class Powerform_Google_Service_Sheets_UpdateProtectedRangeRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $protectedRangeType = 'Powerform_Google_Service_Sheets_ProtectedRange';
  protected $protectedRangeDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setProtectedRange(Powerform_Google_Service_Sheets_ProtectedRange $protectedRange)
  {
    $this->protectedRange = $protectedRange;
  }
  public function getProtectedRange()
  {
    return $this->protectedRange;
  }
}

class Powerform_Google_Service_Sheets_UpdateSheetPropertiesRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SheetProperties';
  protected $propertiesDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setProperties(Powerform_Google_Service_Sheets_SheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
}

class Powerform_Google_Service_Sheets_UpdateSpreadsheetPropertiesRequest extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $fields;
  protected $propertiesType = 'Powerform_Google_Service_Sheets_SpreadsheetProperties';
  protected $propertiesDataType = '';


  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  public function getFields()
  {
    return $this->fields;
  }
  public function setProperties(Powerform_Google_Service_Sheets_SpreadsheetProperties $properties)
  {
    $this->properties = $properties;
  }
  public function getProperties()
  {
    return $this->properties;
  }
}

class Powerform_Google_Service_Sheets_UpdateValuesResponse extends Powerform_Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  public $spreadsheetId;
  public $updatedCells;
  public $updatedColumns;
  public $updatedRange;
  public $updatedRows;


  public function setSpreadsheetId($spreadsheetId)
  {
    $this->spreadsheetId = $spreadsheetId;
  }
  public function getSpreadsheetId()
  {
    return $this->spreadsheetId;
  }
  public function setUpdatedCells($updatedCells)
  {
    $this->updatedCells = $updatedCells;
  }
  public function getUpdatedCells()
  {
    return $this->updatedCells;
  }
  public function setUpdatedColumns($updatedColumns)
  {
    $this->updatedColumns = $updatedColumns;
  }
  public function getUpdatedColumns()
  {
    return $this->updatedColumns;
  }
  public function setUpdatedRange($updatedRange)
  {
    $this->updatedRange = $updatedRange;
  }
  public function getUpdatedRange()
  {
    return $this->updatedRange;
  }
  public function setUpdatedRows($updatedRows)
  {
    $this->updatedRows = $updatedRows;
  }
  public function getUpdatedRows()
  {
    return $this->updatedRows;
  }
}

class Powerform_Google_Service_Sheets_ValueRange extends Powerform_Google_Collection
{
  protected $collection_key = 'values';
  protected $internal_gapi_mappings = array(
  );
  public $majorDimension;
  public $range;
  public $values;


  public function setMajorDimension($majorDimension)
  {
    $this->majorDimension = $majorDimension;
  }
  public function getMajorDimension()
  {
    return $this->majorDimension;
  }
  public function setRange($range)
  {
    $this->range = $range;
  }
  public function getRange()
  {
    return $this->range;
  }
  public function setValues($values)
  {
    $this->values = $values;
  }
  public function getValues()
  {
    return $this->values;
  }
}
