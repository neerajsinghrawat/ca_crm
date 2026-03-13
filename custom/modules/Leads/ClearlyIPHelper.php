<?php
/**
 * ClearlyIP CloudPX API Helper Class
 * Handles authentication and API calls to ClearlyIP CloudPX
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/SugarLogger/LoggerManager.php');
$log = LoggerManager::getLogger();

class ClearlyIPHelper
{
    private $config;
    private $accessToken;
    private $tokenExpiry;
    private $log;
    private $username;
    private $password;

    /**
     * Constructor - Load configuration
     * 
     * @param string $username Optional username for authentication (if not provided, uses config)
     * @param string $password Optional password for authentication (if not provided, uses config)
     */
    public function __construct($username = null, $password = null)
    {
        global $sugar_config, $log;
        
        // Initialize logger
        $this->log = $log;
        
        if (!isset($sugar_config['clearlyip'])) {
            throw new Exception('ClearlyIP configuration not found in config_override.php');
        }
        
        $this->config = $sugar_config['clearlyip'];
        
        // Check if API is enabled
        if (!$this->config['enabled']) {
            throw new Exception('ClearlyIP API is disabled in configuration');
        }
        
        // Use provided credentials or fall back to config
        $this->username = $username !== null ? $username : $this->config['username'];
        $this->password = $password !== null ? $password : $this->config['password'];
    }

    /**
     * Get OAuth access token
     * 
     * @param bool $forceRefresh Force refresh token even if cached
     * @return string Access token
     * @throws Exception on authentication failure
     */
    public function getAccessToken($forceRefresh = false)
    {
        // Check if we have a valid cached token
        if (!$forceRefresh && $this->accessToken && $this->tokenExpiry && time() < $this->tokenExpiry) {
            return $this->accessToken;
        }

        $tokenUrl = $this->config['token_url'];
        
        // Prepare request body
        $postData = array(
            'grant_type' => $this->config['grant_type'],
            'username' => $this->username,
            'password' => $this->password,
            'code' => null,
            'client_id' => null,
            'client_secret' => null,
            'redirect_uri' => null,
            'refresh_token' => null
        );

        // Initialize cURL
        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle errors
        if ($error) {
            $this->log->fatal("ClearlyIP: FATAL - cURL error: {$error}");
            throw new Exception("ClearlyIP API connection error: {$error}");
        }

        if ($httpCode !== 200) {
            $this->log->fatal("ClearlyIP: FATAL - Authentication failed. HTTP {$httpCode}. Response: {$response}");
            throw new Exception("ClearlyIP authentication failed. HTTP Code: {$httpCode}");
        }

        // Parse response
        $data = json_decode($response, true);
        
        if (!isset($data['access_token'])) {
            $this->log->fatal("ClearlyIP: FATAL - No access token in response: {$response}");
            throw new Exception('ClearlyIP: No access token received');
        }

        // Cache token with proper expiry
        $this->accessToken = $data['access_token'];
        
        // Calculate expiry: use created_at + expires_in if available, otherwise use current time + expires_in
        if (isset($data['created_at']) && isset($data['expires_in'])) {
            $this->tokenExpiry = $data['created_at'] + $data['expires_in'];
        } else {
            $this->tokenExpiry = time() + (isset($data['expires_in']) ? $data['expires_in'] : 7199);
        }
        
        return $this->accessToken;
    }

    /**
     * Get current user details from ClearlyIP
     * 
     * @param bool $retry Internal flag for retry logic
     * @return array User details
     * @throws Exception on API failure
     */
    public function getUserDetails($retry = true)
    {
        $accessToken = $this->getAccessToken();
        
        $url = $this->config['base_url'] . $this->config['user_me_endpoint'];

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        ));

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle errors
        if ($error) {
            $this->log->fatal("ClearlyIP: FATAL - cURL error: {$error}");
            throw new Exception("ClearlyIP API connection error: {$error}");
        }

        // If 401 Unauthorized, token might be invalid - refresh and retry once
        if ($httpCode === 401 && $retry) {
            $this->getAccessToken(true); // Force refresh
            return $this->getUserDetails(false); // Retry without further retries
        }

        if ($httpCode !== 200) {
            $this->log->fatal("ClearlyIP: FATAL - Get user failed. HTTP {$httpCode}. Response: {$response}");
            throw new Exception("ClearlyIP get user failed. HTTP Code: {$httpCode}");
        }

        // Parse response
        $data = json_decode($response, true);
        
        return $data;
    }

    /**
     * Originate a callback call
     * 
     * @param string $callee Destination phone number (callee)
     * @param string $extension User's extension
     * @param int $userId ClearlyIP user ID
     * @param int $realmId User's realm ID
     * @param bool $retry Internal flag for retry logic
     * @return array API response
     * @throws Exception on API failure
     */
    public function originateCallback($callee, $extension, $userId, $realmId, $retry = true)
    {
        $accessToken = $this->getAccessToken();
        
        $url = $this->config['base_url'] . $this->config['call_api_endpoint'];
        
        // Prepare call data with correct parameters
        $callData = array(
            'callee' => $callee,
            'extension' => $extension,
            'user_id' => $userId,
            'realm_id' => $realmId
        );

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($callData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle errors
        if ($error) {
            $this->log->fatal("ClearlyIP: FATAL - cURL error: {$error}");
            throw new Exception("ClearlyIP API connection error: {$error}");
        }

        // If 401 Unauthorized, token might be invalid - refresh and retry once
        if ($httpCode === 401 && $retry) {
            $this->getAccessToken(true); // Force refresh
            return $this->originateCallback($callee, $extension, $userId, $realmId, false); // Retry without further retries
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            $this->log->fatal("ClearlyIP: FATAL - Call origination failed. HTTP {$httpCode}. Response: {$response}");
            throw new Exception("ClearlyIP call failed. HTTP Code: {$httpCode}");
        }

        // Parse response
        $data = json_decode($response, true);
        
        return $data;
    }

    /**
     * Make a generic API request to ClearlyIP
     * 
     * @param string $endpoint API endpoint (e.g., '/users/me')
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param array $data Request body data (for POST/PUT)
     * @param bool $retry Internal flag for retry logic
     * @return array API response
     * @throws Exception on API failure
     */
    public function makeRequest($endpoint, $method = 'GET', $data = array(), $retry = true)
    {
        $accessToken = $this->getAccessToken();
        
        $url = $this->config['base_url'] . $endpoint;

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        $headers = array(
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        );
        
        if (!empty($data) && in_array($method, array('POST', 'PUT', 'PATCH'))) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $headers[] = 'Content-Type: application/json';
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle errors
        if ($error) {
            $this->log->fatal("ClearlyIP: FATAL - cURL error: {$error}");
            throw new Exception("ClearlyIP API connection error: {$error}");
        }

        // If 401 Unauthorized, token might be invalid - refresh and retry once
        if ($httpCode === 401 && $retry) {
            $this->getAccessToken(true); // Force refresh
            return $this->makeRequest($endpoint, $method, $data, false); // Retry without further retries
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            $this->log->fatal("ClearlyIP: FATAL - Request failed. HTTP {$httpCode}. Response: {$response}");
            throw new Exception("ClearlyIP API request failed. HTTP Code: {$httpCode}");
        }

        // Parse response
        $data = json_decode($response, true);
        
        return $data;
    }

}

