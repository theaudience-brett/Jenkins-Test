<?php
/**
 * @package    bankaccount
 * @subpackage framework
 */
class Response extends HashMap
{
    protected $headers = array();

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
