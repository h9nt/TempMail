<?php
header('Content-Type: application/json');

class TempMail {
    public static function getEmail($domain, $name, $token) {
        try {
            $curl = curl_init();
            $headers = [
                "Accept-Encoding: gzip",
                "Connection: Keep-Alive",
                "Content-Type: application/json",
                "Host: api.internal.temp-mail.io",
                "User-Agent: okhttp/4.5.0"
            ];
            $payload = [
                'domain' => $domain,
                'name' => $name,
                'token' => $token
            ];
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.internal.temp-mail.io/api/v3/email/new",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => $headers,
            ]);
    
            $response = curl_exec($curl);
            $vardxg = json_decode($response, true);
            if (!$vardxg['email'] || !$vardxg['token']) {
                echo json_encode([
                    'status' => false,
                    'extra' => $vardxg,
                    'now' => time()
                ]);
                exit;
            } else {
                try {
                    echo json_encode([
                        'status' => true,
                        'email' => $vardxg['email'],
                        'token' => $token,
                        'now' => time()
                    ]);
                    exit;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        } catch (Exception $d) {
            return $d->getMessage();
        }
    }

    public static function uuid4() {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://www.uuidgenerator.net/version4/bulk.json?amount=1",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => [
                    "User-Agent: insomnia/2023.5.8"
                ],
            ]);
    
            $response = curl_exec($curl);
            $a = json_decode($response, true);
            return $a[0];
        } catch (Exception $e) {
            return $e->getCode();
        }
    }
    
    public static function device_register() {
        try {
            $curl = curl_init();
            $headers = [
                "Accept-Encoding: gzip",
                "Connection: Keep-Alive",
                "Content-Type: application/json",
                "Host: api.internal.temp-mail.io",
                "User-Agent: okhttp/4.5.0"
            ];
            $payload = [
                'app_version' => '1.1.0-8058ba44',
                'device_id' => TempMail::uuid4()
            ];
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.internal.temp-mail.io/api/v3/device/register",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => $headers,
            ]);
    
            $response = curl_exec($curl);
            try {
                if (!empty($response)) {
                    return false;
                } else {
                    return true;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } catch (Exception $f) {
            return $f->getCode();
        }
    }

    public static function inbox($email) {
        try {
            $curl = curl_init();
            $headers = [
                "Accept-Encoding: gzip",
                "Connection: Keep-Alive",
                "Host: api.internal.temp-mail.io",
                "User-Agent: okhttp/4.5.0"
            ];
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.internal.temp-mail.io/api/v3/email/{$email}/messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => $headers,
            ]);
    
            $response = curl_exec($curl);
            $vardxg = json_decode($response, true);
            if (!$vardxg['[]']) {
                echo json_encode([
                    'email' => $email,
                    'inbox' => [
                        'id' => $vardxg[0]['id'],
                        'from' => $vardxg[0]['from'],
                        'to' => $vardxg[0]['to'],
                        'cc' => $vardxg[0]['cc'],
                        'subject' => $vardxg[0]['subject'],
                        'body' => $vardxg[0]['body_text'],
                    ],
                    'now' => time()
                ]);
                exit;
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'no emails',
                    'now' => time()
                ]);
                exit;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
}

?>