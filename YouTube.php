<?php

class YouTube
{
	protected $channel;

	protected $api = 'https://www.googleapis.com/youtube/v3/search';

	protected $key;

	protected $information = array();

	public function __construct($channel, $key = null)
	{
		$this->channel = $channel;
		$this->key = $key;
	}

	public function getKey()
	{
		if ($this->key === null)
		{
			throw new \RuntimeException("You need to provide a Google Project key");
		}

		return $this->key;
	}

	public function query($pageToken = null)
	{
		$query = new Curl($this->api);

		if ($pageToken !== null)
		{
			$query->with('pageToken', $pageToken); // als er is aangegeven dat we een andere pagina willen, zeg dit tegen Google.
		}

		$query->with('part', 'snippet')           // haal ook alle titles / descriptions op
			  ->with('q', 'vera')                 // alleen de videos waar 'vera' in voorkomt
			  ->with('channelId', $this->channel) // alleen videos van een bepaald channel
			  ->with('maxResults', 50)             // zoveel mogelijk resultaten per query
			  ->with('key', $this->getKey());     // Gebruik de key van een bepaald google dev. project

		$result = json_decode($query->send());

		$items = $result->items;

		if (isset($result->nextPageToken)) // als er een volgende pagina is
		{
			$items = array_merge($items, $this->query($result->nextPageToken)); // haal die ook op en stop hem bij de rest.
		}

		return $items;
	}

	public function asdf()
	{
		$query = new Curl($this->api);

		$query->with('part', 'snippet')           // haal ook alle titles / descriptions op
			  ->with('q', 'vera')                 // alleen de videos waar 'vera' in voorkomt
			  ->with('channelId', $this->channel) // alleen videos van een bepaald channel
			  ->with('maxResults', 50)             // zoveel mogelijk resultaten per query
			  ->with('key', $this->getKey());     // Gebruik de key van een bepaald google dev. project

		$result = json_decode($query->send());

		$items = $result->items;

		$query = new Curl($this->api);

		$query->with('part', 'snippet')           // haal ook alle titles / descriptions op
			  ->with('q', 'vera')                 // alleen de videos waar 'vera' in voorkomt
			  ->with('channelId', $this->channel) // alleen videos van een bepaald channel
			  ->with('maxResults', 50)            // zoveel mogelijk resultaten per query
			  ->with('key', $this->getKey())      // Gebruik de key van een bepaald google dev. project
			  ->with('nextPageToken', 'CDIQAA');

		$items = array_merge($items, json_decode($query->send())->items);

		return $items;
	}
}
