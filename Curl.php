<?php

class Curl
{
	protected $to;
	protected $parameters = array();

	public function __construct($url)
	{
		if (! extension_loaded('curl'))
		{
			throw new \RuntimeException("The extension 'cURL' is required. Please install before continueing.");
		}

		$this->to = $url;
	}

	public function with($key, $value)
	{
		$this->parameters[$key] = $value;

		return $this;
	}

	public function send()
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $this->compileURL($this->to, $this->parameters));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);

		curl_close($curl);

		return $result;
	}

	protected function compileURL($url, array $parameters)
	{
		if (empty($parameters)) return $url;

		$url .= '?';

		foreach ($parameters as $key => $parameter)
		{
			$url .= urlencode($key) . '=' . urlencode($parameter) . '&';
		}

		return substr($url, 0, -1);
	}
}