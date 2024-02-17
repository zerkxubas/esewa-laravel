<?php declare(strict_types=1);

namespace Zerkxubas\EsewaLaravel;

use Exception;
use Zerkxubas\EsewaLaravel\EsewaConfig as Config;

final class Client
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * This method creates the form data for eSewa server.
     */
    public function prepareFormData(string $productId, float $amount, float $taxAmount, float $serviceAmount = 0.0, float $deliveryAmount = 0.0): array
    {
        return [
            'scd' => $this->config->merchantCode,
            'su' => $this->config->successUrl,
            'fu' => $this->config->failureUrl . '?' . http_build_query(['pid' => $productId]),
            'pid' => $productId,
            'amt' => $amount,
            'txAmt' => $taxAmount,
            'psc' => $serviceAmount,
            'pdc' => $deliveryAmount,
            'tAmt' => $amount + $taxAmount + $serviceAmount + $deliveryAmount,
        ];
    }

    /**
     * This method creates the form HTML for eSewa server.
     */
    public function generateFormHtml(array $formData): string
    {
        $formHtml = '<form method="POST" action="' . ($this->config->apiUrl . '/epay/main') . '" id="esewa-form">';

        foreach ($formData as $name => $value) {
            $formHtml .= sprintf('<input name="%s" type="hidden" value="%s">', $name, $value);
        }

        $formHtml .= '</form><script type="text/javascript">document.getElementById("esewa-form").submit();</script>';

        return $formHtml;
    }

    /**
     * This method processes the payment by preparing form data and generating form HTML.
     */
    public function checkout(string $productId, float $amount, float $taxAmount, float $serviceAmount = 0.0, float $deliveryAmount = 0.0): string
    {
        $formData = $this->prepareFormData($productId, $amount, $taxAmount, $serviceAmount, $deliveryAmount);
        return $this->generateFormHtml($formData);
    }

    /**
     * This method verifies the payment using the reference ID.
     * @throws Exception
     */
    public function verifyPayment(string $referenceId, string $productId, float $amount): bool
    {
        // Initialize a cURL handle
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $this->config->apiUrl . '/epay/transrec');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        // Set HTTP headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/xml',
        ]);

        // Set the request data
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'scd' => $this->config->merchantCode,
            'rid' => $referenceId,
            'pid' => $productId,
            'amt' => $amount,
        ]));

        // Send the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch) !== 0) {
            // Handle errors here
            throw new Exception(curl_error($ch));
        }

        // Close the cURL handle
        curl_close($ch);

        // Parse the XML response
        $status = $this->parseXml($response);

        // check for "success" or "failure" status
        return strtolower($status) === 'success';
    }

    /**
     * This method parse XML string and return the object.
     */
    private function parseXml(string $xmlStr): string
    {
        // Load the XML string
        $xml = simplexml_load_string($xmlStr);
        // extract the value
        return trim((string)$xml->response_code);
    }
}