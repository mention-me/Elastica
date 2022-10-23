<?php
namespace Elastica\Bulk;

use Elastica\Response as BaseResponse;

class ResponseSet extends BaseResponse implements \Iterator, \Countable
{
    /**
     * @var Response[]
     */
    protected $_bulkResponses = array();

    /**
     * @var int
     */
    protected $_position = 0;

    /**
     * @param BaseResponse $response
     * @param Response[] $bulkResponses
     */
    public function __construct(BaseResponse $response, array $bulkResponses)
    {
        parent::__construct($response->getData());

        $this->_bulkResponses = $bulkResponses;
    }

    /**
     * @return Response[]
     */
    public function getBulkResponses()
    {
        return $this->_bulkResponses;
    }

    /**
     * Returns first found error.
     *
     * @return string
     */
    public function getError()
    {
        $error = '';

        foreach ($this->getBulkResponses() as $bulkResponse) {
            if ($bulkResponse->hasError()) {
                $error = $bulkResponse->getError();
                break;
            }
        }

        return $error;
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        $return = true;

        foreach ($this->getBulkResponses() as $bulkResponse) {
            if (!$bulkResponse->isOk()) {
                $return = false;
                break;
            }
        }

        return $return;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        $return = false;

        foreach ($this->getBulkResponses() as $bulkResponse) {
            if ($bulkResponse->hasError()) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    /**
     * @return bool|Response
     */
    public function current(): mixed
    {
        if ($this->valid()) {
            return $this->_bulkResponses[$this->key()];
        } else {
            return false;
        }
    }

    /**
     */
    public function next(): void
    {
        ++$this->_position;
    }

    /**
     * @return int
     */
    public function key(): mixed
    {
        return $this->_position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->_bulkResponses[$this->key()]);
    }

    /**
     */
    public function rewind(): void
    {
        $this->_position = 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->_bulkResponses);
    }
}
