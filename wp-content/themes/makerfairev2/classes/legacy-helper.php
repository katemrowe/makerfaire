<?php
/**
 * Check if a URL is in a specified whitelist
 *
 * Example whitelist: array( 'mydomain.com', 'mydomain.net' )
 *
 * @param string $url URL to check for
 * @param array $whitelisted_domains Array of whitelisted domains
 * @return bool Returns true if $url is in the $whitelisted_domains
 */
function legacy_is_valid_domain( $url, $whitelisted_domains ) {
	$domain = parse_url( $url, PHP_URL_HOST );

	if ( ! $domain )
		return false;

	// Check if we match the domain exactly
	if ( in_array( $domain, $whitelisted_domains ) )
		return true;

	$valid = false;

	foreach( $whitelisted_domains as $whitelisted_domain ) {
		$whitelisted_domain = '.' . $whitelisted_domain; // Prevent things like 'evilsitetime.com'
		if( strpos( $domain, $whitelisted_domain ) === ( strlen( $domain ) - strlen( $whitelisted_domain ) ) ) {
			$valid = true;
			break;
		}
	}
	return $valid;
}
