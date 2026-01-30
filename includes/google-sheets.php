<?php
class GoogleSheets {
    private $spreadsheetId;
    private $credentialsPath;
    private $accessToken;
    
    public function __construct($spreadsheetId) {
        $this->spreadsheetId = $spreadsheetId;
        $this->credentialsPath = __DIR__ . '/credentials/credentials.json';
        $this->accessToken = $this->getAccessToken();
    }
    
    private function getAccessToken() {
        if (!file_exists($this->credentialsPath)) {
            throw new Exception('Credentials file not found. Please place your credentials.json in the includes/credentials directory.');
        }

        $credentials = json_decode(file_get_contents($this->credentialsPath), true);
        
        // Check if we have a valid cached token
        $tokenFile = __DIR__ . '/credentials/token.json';
        if (file_exists($tokenFile)) {
            $token = json_decode(file_get_contents($tokenFile), true);
            if ($token['expires_at'] > time()) {
                return $token['access_token'];
            }
        }

        // Get new token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id' => $credentials['installed']['client_id'],
            'client_secret' => $credentials['installed']['client_secret'],
            'refresh_token' => $credentials['installed']['refresh_token'],
            'grant_type' => 'refresh_token'
        ]));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception('Failed to get access token: ' . $response);
        }

        $tokenData = json_decode($response, true);
        
        // Cache the token
        $tokenData['expires_at'] = time() + $tokenData['expires_in'];
        file_put_contents($tokenFile, json_encode($tokenData));

        return $tokenData['access_token'];
    }
    
    public function appendRow($data) {
        if (empty($this->spreadsheetId)) {
            throw new Exception('Spreadsheet ID is not set');
        }

        $values = [
            [
                date('Y-m-d H:i:s'), // Timestamp
                $data['name'] ?? '',
                $data['phone'] ?? '',
                $data['email'] ?? '',
                $data['message'] ?? ''
            ]
        ];

        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/Sheet1!A:E:append";
        $url .= "?valueInputOption=RAW&insertDataOption=INSERT_ROWS";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'values' => $values
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            error_log('Google Sheets Error: ' . $response);
            return false;
        }

        return true;
    }
}
?> 