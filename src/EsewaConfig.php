<?php declare(strict_types=1);

namespace Zerkbro\EsewaLaravel;

final class EsewaConfig
{
    /**
     * The API url for development mode
     */
    public string $apiUrl;

    /**
     * The merchant code provided by eSewa
     */
    public string $merchantCode;

    /**
     * The callback URL for successful eSewa payments
     */
    public string $successUrl;

    /**
     * The callback URL for failed eSewa payments
     */
    public string $failureUrl;

    public function __construct()
    {
        $this->apiUrl = config('esewa.api_url');
        $this->merchantCode = config('esewa.merchant_code');
        $this->successUrl = config('esewa.success_url');
        $this->failureUrl = config('esewa.failure_url');
        $this->esewaDebugMode = config('esewa.debug_mode')

        // verifying ESEWA payment is in development or not.
        if (strtoupper($this->merchantCode) !== 'EPAYTEST' && $this->esewaDebugMode !== true) {
            $this->apiUrl = 'https://esewa.com.np';
        }
    }
}