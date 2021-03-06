<?php

/**
 * ElasticSearch Search
 *
 * @author emi
 */

namespace Minds\Core\Data\ElasticSearch\Prepared;

use Minds\Core\Data\Interfaces\PreparedMethodInterface;

class Match implements PreparedMethodInterface
{
    /** @var string $_index */
    protected $_index;

    /** @var array $_match */
    protected $_match;

    /** @var array $_filters */
    protected $_filters;

    /** @var array $_params */
    protected $_params;

    /**
     * @param array $match
     * @param array $filters
     * @param array $params
     */
    public function query($index, array $match, array $filters = [], array $params = [])
    {
        $this->_index = $index;
        $this->_match = $match;
        $this->_filters = $filters;
        $this->_params = $params;
    }

    /**
     * Build the prepared request
     * @return array
     */
    public function build()
    {
        // Match

        $multi_match = array_merge([
            'fields' => [ '_all', 'name^6', 'title^8', 'message^8', 'username^8', 'tags^16' ],
            'operator' => 'AND',
            'minimum_should_match' => "75%"
        ], $this->_match);

        // Filter

        $filter = [];

        foreach ($this->_filters as $term => $value) {
            if (is_array($value)) {
                $filter[] = [ 'terms' => [ $term => $value ] ];
            } else {
                $filter[] = [ 'term' => [ $term => $value ] ];
            }
        }

        // Build the request

        $body = [
            'query' => [
                'bool' => [ ]
            ]
        ];

        if ($filter) {
            $body['query']['bool']['filter'] = $filter;
        }

        $body['query']['bool']['must'] = [
            'multi_match' => $multi_match
        ];

        // Score

        if (isset($this->_params['field_value_factor'])) {
            $body = [
                'query' => [
                    'function_score' => [
                        'query' => $body['query'],
                        'field_value_factor' => $this->_params['field_value_factor']
                    ]
                ]
            ];
        }

        // Sorting

        if (isset($this->_params['sort'])) {
            $body['sort'] = $this->_params['sort'];
        }

        //

        $request = [
            'index' => $this->_index,
            'body' => $body
        ];

        if (isset($this->_params['size'])) {
            $request['size'] = $this->_params['size'];
        }

        if (isset($this->_params['from'])) {
            $request['from'] = $this->_params['from'];
        }

        return $request;
    }

    /**
     * Return options for the query
     */
    public function getOpts()
    {
    }

    /**
     * Sets the prepared method
     * @return string
     */
    public function getMethod()
    {
        return 'search';
    }
}
