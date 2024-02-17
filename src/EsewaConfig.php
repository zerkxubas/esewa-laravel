<?php declare(strict_types=1);

namespace Zerkxubas\EsewaLaravel;

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

    public bool $esewaDebugMode;

    public function __construct()
    {
        $this->esewaDebugMode = config('esewa.debug_mode', true);
        $this->apiUrl = $this->getApiUrl();
        $this->merchantCode = config('esewa.merchant_code', 'EPAYTEST');
        $this->successUrl = config('esewa.success_url', 'http://localhost/order/success');
        $this->failureUrl = config('esewa.failure_url', 'http://localhost/payment/failure');
    }

    private function getApiUrl(): string
    {
        $defaultApiUrl = 'https://uat.esewa.com.np';
        return $this->esewaDebugMode ? $defaultApiUrl : $this->apiUrl;
    }

}