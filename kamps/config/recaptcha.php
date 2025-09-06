<?php
// reCAPTCHA Keys (same for PC, Mobile, Tablet)
 define('RECAPTCHA_SITE_KEY', '6LeMM6krAAAAANRkXMPFetTJAgIC3be9pvvFnBd8');
 define('RECAPTCHA_SECRET_KEY', '6LeMM6krAAAAAPOyLAvGGNpDsn0cBhtua2kx3QDl');

/**
 * Verify Google reCAPTCHA Response
 *
 * @param string $response The g-recaptcha-response from form
 * @return bool True if passed, False if failed
 */
function verifyRecaptcha($response) {
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $response
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result   = file_get_contents($url, false, $context);
    $resultJson = json_decode($result);

    return $resultJson->success;
}
?>
