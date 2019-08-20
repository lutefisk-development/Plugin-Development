<?php

class SpotifyAPI
{
    protected $access_token;
    protected $client_id;
    protected $client_secret;

    public function __construct($client_id, $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function getAccessToken()
    {
        if ($this->access_token) {
            return $this->access_token;
        }

        // else, authenticate with Spotify API and store access_token in $this->access_token, and return it.
        $session = new SpotifyWebAPI\Session(
            $this->client_id,
            $this->client_secret
        );

        $session->requestCredentialsToken();
        $this->access_token = $session->getAccessToken();

        return $this->access_token;

    }

    public function getNewReleases()
    {
        // connect to spotify and get new releases
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($this->getAccessToken());

        // getting the 3 latest releases from Sweden.
        return $api->getNewReleases(['country' => 'SE', 'limit' => 3]);
    }
}
