<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 *
 * @copyright Copyright (c)2006-2016 Nicholas K. Dionysopoulos
 * @license   GNU GPL version 3 or, at your option, any later version
 * @package   akeebaengine
 *
 *
 * Dropbox API implementation in PHP
 *
 * Modified by Nicholas K. Dionysopoulos <nikosdion@gmail.com>
 *
 * Based on the work of Ben Tadiar <ben@handcraftedbyben.co.uk>, found at
 * https://github.com/benthedesigner/dropbox and licensed under the MIT license.
 *
 * The following license notice is present in the original code:
 *
 * Copyright (c) 2012 Ben Tadiar
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Akeeba\Engine\Postproc\Connector\Cloudfiles;

// Protection against direct access
use Akeeba\Engine\Postproc\Connector\Azure\Exception\Http;

defined('AKEEBAENGINE') or die();

/**
 * RESTful API request abstraction
 */
class Request
{
	/** @var string The HTTP verb to use, e.g. GET, POST, PUT, HEAD, DELETE */
	private $verb;

	/** @var string The API URL to call */
	private $url;

	/** @var array Query string parameters */
	private $parameters = array();

	/** @var array Headers to send with the request */
	private $headers = array();

	/** @var bool|resource File pointer for GET and POST data */
	public $fp = false;

	/** @var int Size of the POST data */
	public $size = 0;

	/** @var bool|string POST data */
	public $data = false;

	/** @var null|\stdClass The response object */
	public $response = null;

	/**
	 * Constructor
	 *
	 * @param string $verb Verb
	 * @param string $url  Object URI
	 *
	 * @return Request
	 */
	function __construct($verb, $url = '')
	{
		$this->verb = $verb;

		$this->url = $url;

		$this->response = new \stdClass();
		$this->response->error = false;
	}

	/**
	 * Set request parameter
	 *
	 * @param string $key   Key
	 * @param string $value Value
	 *
	 * @return void
	 */
	public function setParameter($key, $value)
	{
		$this->parameters[$key] = $value;
	}


	/**
	 * Set request header
	 *
	 * @param string $key   Key
	 * @param string $value Value
	 *
	 * @return void
	 */
	public function setHeader($key, $value)
	{
		$this->headers[$key] = $value;
	}


	/**
	 * Get the response
	 *
	 * @return object | false
	 *
	 * @throws Http When something goes awry
	 */
	public function getResponse()
	{
		$query = '';

		if (sizeof($this->parameters) > 0)
		{
			$query = substr($this->url, -1) !== '?' ? '?' : '&';

			foreach ($this->parameters as $var => $value)
			{
				$addToQuery = $var . '&';

				if (!($value == null || $value == ''))
				{
					$addToQuery = $var . '=' . rawurlencode($value) . '&';
				}

				$query .= $addToQuery;
			}

			$query = substr($query, 0, -1);

			$this->url .= $query;
		}

		// Basic setup
		$curl = curl_init();

		@curl_setopt($curl, CURLOPT_CAINFO, AKEEBA_CACERT_PEM);

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

		curl_setopt($curl, CURLOPT_USERAGENT, 'AkeebaBackup/4.0');
		curl_setopt($curl, CURLOPT_URL, $this->url);
		// Set an infinite timeout and hope for the best
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		// Headers
		$headers = array();

		foreach ($this->headers as $header => $value)
		{
			if (strlen($value) > 0)
			{
				$headers[] = $header . ': ' . $value;
			}
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($curl, CURLOPT_WRITEFUNCTION, array(&$this, '__responseWriteCallback'));
		curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$this, '__responseHeaderCallback'));
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

		// Request types
		switch ($this->verb)
		{
			case 'GET':
				break;
			case 'PUT':
			case 'POST': // POST only used for CloudFront
				if ($this->fp !== false)
				{
					curl_setopt($curl, CURLOPT_PUT, true);
					curl_setopt($curl, CURLOPT_INFILE, $this->fp);
					if ($this->size >= 0)
					{
						curl_setopt($curl, CURLOPT_INFILESIZE, $this->size);
					}
				}
				elseif ($this->data !== false)
				{
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->verb);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
					if ($this->size >= 0)
					{
						curl_setopt($curl, CURLOPT_BUFFERSIZE, $this->size);
					}
				}
				else
				{
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->verb);
				}
				break;
			case 'HEAD':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');
				curl_setopt($curl, CURLOPT_NOBODY, true);
				break;
			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			default:
				break;
		}

		// Execute, grab errors
		if (curl_exec($curl))
		{
			$this->response->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		}
		else
		{
			$this->response->error = array(
				'code'    => curl_errno($curl),
				'message' => curl_error($curl),
				'url'     => $this->url
			);
		}

		@curl_close($curl);

		// Parse body into XML
		if (
			($this->response->error === false)
			&& isset($this->response->headers['Content-Type'])
			&& (strstr($this->response->headers['Content-Type'], 'application/json') !== false)
			&& isset($this->response->body)
		)
		{
			$this->response->body = json_decode($this->response->body);
		}

		if ($this->response->error || ($this->response->code >= 400))
		{
			if (!empty($this->response->body))
			{
				$body = json_encode($this->response->body);
				$body = json_decode($body, true);

				$this->response->code = '-1';
				$this->response->error = $this->response->body;

				if (is_array($body))
				{
					$allKeys = array_keys($body);
					$firstKey = array_shift($allKeys);
					$errorInfo = $body[$firstKey];

					if (isset($errorInfo['code']))
					{
						$this->response->code = $errorInfo['code'];
					}

					if (isset($errorInfo['message']))
					{
						$this->response->error = $errorInfo['message'];
					}
					else
					{
						$this->response->error = $firstKey;
					}
				}
			}

			if (empty($this->response->error) || empty($this->response->code))
			{
				$this->response->error = 'Timeout';
				$this->response->code = 0;
			}
			throw new Http($this->response->error, $this->response->code);
		}

		// Clean up file resources
		if (($this->fp !== false) && is_resource($this->fp))
		{
			fclose($this->fp);
		}

		return $this->response;
	}


	/**
	 * CURL write callback
	 *
	 * @param resource &$curl CURL resource
	 * @param string   &$data Data
	 *
	 * @return integer
	 */
	protected function  __responseWriteCallback(&$curl, &$data)
	{
		if (in_array($this->response->code, array(200, 206)) && $this->fp !== false)
		{
			return fwrite($this->fp, $data);
		}
		else
		{
			$this->response->body .= $data;
		}

		return strlen($data);
	}


	/**
	 * CURL header callback
	 *
	 * @param resource &$curl CURL resource
	 * @param string   &$data Data
	 *
	 * @return integer
	 */
	protected function  __responseHeaderCallback(&$curl, &$data)
	{
		$strlen = strlen($data);

		if ($strlen <= 2)
		{
			return $strlen;
		}

		if (substr($data, 0, 4) == 'HTTP')
		{
			$this->response->code = (int)substr($data, 9, 3);
		}
		else
		{
			list($header, $value) = explode(': ', trim($data), 2);
			$this->response->headers[$header] = is_numeric($value) ? (int)$value : $value;
		}

		return $strlen;
	}
}