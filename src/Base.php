<?php

namespace Redscript\LinkedIn;
use Redscript\LinkedIn\Factory;

class Base 
{
	/* Constants
    -------------------------------*/
    const HOST                  = 'https://www.linkedin.com';
    const LINKED_API            = 'https://api.linkedin.com/v1/people';
	const LINKEDIN_OAUTH_URL    = self::HOST . '/uas/oauth2';
    const LINKEDIN_AUTH         = self::LINKEDIN_OAUTH_URL . '/authorization';
    const LINKEDIN_ACCESS_TOKEN = self::LINKEDIN_OAUTH_URL . '/accessToken';
    const RESPONSE_TYPE         = 'code';
    const STATE                 = 'CSRF';

	/* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    protected $client_id;
	protected $client_secret;
	protected $redirect_uri;
	protected $scope;
    protected $format;
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    /* Protected Methods
    -------------------------------*/
}

$url = 'https://api.linkedin.com/v1/people/~:(id,num-connections,picture-url,email-address,first-name,last-name,picture-urls::(original))?format=json'; 