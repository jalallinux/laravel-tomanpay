<?php

namespace JalalLinuX\Tomanpay\Model;

use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use JalalLinuX\Tomanpay\Enum\PaymentStatusEnum;

class Payment extends BaseModel
{
    private string $uuid;

    private int $amount;

    private int $toman_wage;

    private int $wage;

    private int $shaparak_wage;

    private int $status;

    private string $psp;

    private string $terminal_number;

    private string $created_at;

    private bool $check_national_id = false;

    private ?string $mobile_number = null;

    private ?string $callback_url = null;

    private ?string $masked_paid_card_number = null;

    private ?int $acceptor_code = null;

    private ?string $tracker_id = null;

    private ?string $verified_at = null;

    private ?string $trace_number = null;

    private ?string $reference_number = null;

    private ?string $digital_receipt_number = null;

    /**
     * Creates a new Payment and gets a token for it from the automatically chosen PSP
     *
     * @param  int  $amount The amount to be paid, in Rials. Note that this is the amount that the user will be paying in the payment gateway.
     * @param  string  $callbackUrl This is an absolute URL to your callback endpoint which will be called after user has finished the payment process. Note that the domain of your callback_url must be registered and validated in Toman.
     * @param  string|null  $mobile_number The mobile number to be delivered to the PSP. When this field is provided, the PSP will suggest the card numbers that the user used before to them. It is also used in the process of National ID check.
     * @param  bool  $check_national_id Performs a check on the National ID of the owner of the card against the National ID of the owner of the mobile number and aborts the payment if they don't match. The mobile_number should not be null if this value is true
     * @param  string|null  $tracker_id This is an ID you can provide for the payment, which will be returned to your callback_url for you to verify the payment. Note that due to security reasons, It is highly advised to generate and save a tracker_id for each payment in your database.
     * @param  array|null  $card_numbers The list of the card numbers to be used in the payment process. If you want to limit the card numbers by which the users pays, you can fill this field.
     * @return self
     *
     * @scope payment.create
     *
     * @author JalalLinuX
     */
    public static function create(int $amount, string $callbackUrl, string $mobile_number = null, bool $check_national_id = false, string $tracker_id = null, array $card_numbers = null): self
    {
        $payload = [
            'amount' => $amount,
            'callbackUrl' => $callbackUrl,
            'mobile_number' => $mobile_number,
            'check_national_id' => $check_national_id,
            'tracker_id' => $tracker_id,
            'card_numbers' => $card_numbers,
        ];

        $response = self::api()->post('payments', $payload)->json();

        return self::fromArray($response);
    }

    /**
     * Used for get all Payments record with pagination.
     *
     * @param  int  $page
     * @return LengthAwarePaginator
     *
     * @scope payment.list
     *
     * @author JalalLinuX
     */
    public static function list(int $page = 1): LengthAwarePaginator
    {
        $response = self::api()->get('payments', [
            'page' => $page,
        ])->json();

        return new LengthAwarePaginator(
            array_map(fn ($data) => self::fromArray($data), $response['results']),
            $response['count'], count($response['results']), $page
        );
    }

    /**
     * Retrieve details of a payment.
     *
     * @param  string  $uuid
     * @return Payment
     *
     * @scope payment.detail
     *
     * @author JalalLinuX
     */
    public static function detail(string $uuid): Payment
    {
        $response = self::api()->get("payments/{$uuid}")->json();

        return self::fromArray($response);
    }

    /**
     * When the payment is successful Toman will inform you about the status of the payment through your callback endpoint.
     * You must check the validity of the data (e.g. Check that the reference_number field is unique to prevent double-spending attacks) and then verify the payment.
     * This step is required to prevent refunding the money to the user.
     * If verification is successful, you will receive 204 status code, otherwise an HTTP 400 status code with the proper error detail will be provided to you.
     *
     * @param  string  $uuid The uuid field of the payment
     * @param  bool  $throw Throw exception if not verified
     * @return bool
     *
     * @scope payment.verify
     *
     * @author JalalLinuX
     */
    public static function verify(string $uuid, bool $throw = true): bool
    {
        $response = self::api($throw)->post("payments/{$uuid}/verify");

        return $response->successful();
    }

    /**
     * Redirects the customer to the payment gateway.
     * After you created the payment, you should redirect your user to the following url.
     * Toman will notify you with payment result when the customer has finished the payment.
     * Note the redirect is difference with send request.
     * Redirecting to this endpoint is usually implemented via an HTTP redirect response.
     *
     * @param  string  $uuid The UUID of the payment
     * @return RedirectResponse
     *
     * @scope payment.redirect
     *
     * @author JalalLinuX
     */
    public static function redirect(string $uuid): RedirectResponse
    {
        $baseUrl = self::config('base_url');
        if (! str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        return Redirect::away("{$baseUrl}payments/{$uuid}/redirect");
    }

    public static function fromArray(array $array): self
    {
        $payment = new self;
        foreach ($array as $k => $v) {
            $method = 'set'.ucfirst(Str::camel($k));
            $payment->{$method}($v);
        }

        return $payment;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getWage(): int
    {
        return $this->wage;
    }

    public function getTomanWage(): int
    {
        return $this->toman_wage;
    }

    public function getShaparakWage(): int
    {
        return $this->shaparak_wage;
    }

    public function getStatus(): PaymentStatusEnum
    {
        return PaymentStatusEnum::from($this->status);
    }

    public function getPsp(): string
    {
        return $this->psp;
    }

    public function getTerminalNumber(): string
    {
        return $this->terminal_number;
    }

    public function getCreatedAt(): Carbon
    {
        return Carbon::parse($this->created_at);
    }

    public function isCheckNationalId(): bool
    {
        return $this->check_national_id;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobile_number;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->callback_url;
    }

    public function getTrackerId(): ?string
    {
        return $this->tracker_id;
    }

    public function getVerifiedAt(): ?Carbon
    {
        return ! is_null($this->verified_at) ? Carbon::parse($this->verified_at) : null;
    }

    public function getTraceNumber(): ?string
    {
        return $this->trace_number;
    }

    public function getReferenceNumber(): ?string
    {
        return $this->reference_number;
    }

    public function getDigitalReceiptNumber(): ?string
    {
        return $this->digital_receipt_number;
    }

    public function getMaskedPaidCardNumber(): ?string
    {
        return $this->masked_paid_card_number;
    }

    public function getAcceptorCode(): ?string
    {
        return $this->acceptor_code;
    }

    public function setUuid(string $uuid): self
    {
        throw_if(! Str::isUuid($uuid), new \Exception('Payment uuid must be a valid UUID 4 format.'));

        return tap($this, fn () => $this->uuid = $uuid);
    }

    public function setAmount(int $amount): self
    {
        return tap($this, fn () => $this->amount = $amount);
    }

    public function setTomanWage(int $toman_wage): self
    {
        return tap($this, fn () => $this->toman_wage = $toman_wage);
    }

    public function setWage(int $wage): self
    {
        return tap($this, fn () => $this->wage = $wage);
    }

    public function setShaparakWage(int $shaparak_wage): self
    {
        return tap($this, fn () => $this->shaparak_wage = $shaparak_wage);
    }

    public function setStatus(int $status): self
    {
        return tap($this, fn () => $this->status = $status);
    }

    public function setPsp(string $psp): self
    {
        return tap($this, fn () => $this->psp = $psp);
    }

    public function setTerminalNumber(string $terminal_number): self
    {
        return tap($this, fn () => $this->terminal_number = $terminal_number);
    }

    public function setCreatedAt(string $created_at): self
    {
        return tap($this, fn () => $this->created_at = $created_at);
    }

    public function setCheckNationalId(bool $check_national_id): self
    {
        return tap($this, fn () => $this->check_national_id = $check_national_id);
    }

    public function setMobileNumber(?string $mobile_number): self
    {
        return tap($this, fn () => $this->mobile_number = $mobile_number);
    }

    public function setCallbackUrl(?string $callback_url): self
    {
        return tap($this, fn () => $this->callback_url = $callback_url);
    }

    public function setTrackerId(?string $tracker_id): self
    {
        return tap($this, fn () => $this->tracker_id = $tracker_id);
    }

    public function setVerifiedAt(?string $verified_at): self
    {
        return tap($this, fn () => $this->verified_at = $verified_at);
    }

    public function setTraceNumber(?string $trace_number): self
    {
        return tap($this, fn () => $this->trace_number = $trace_number);
    }

    public function setReferenceNumber(?string $reference_number): self
    {
        return tap($this, fn () => $this->reference_number = $reference_number);
    }

    public function setDigitalReceiptNumber(?string $digital_receipt_number): self
    {
        return tap($this, fn () => $this->digital_receipt_number = $digital_receipt_number);
    }

    public function setMaskedPaidCardNumber(?string $masked_paid_card_number): self
    {
        return tap($this, fn () => $this->masked_paid_card_number = $masked_paid_card_number);
    }

    public function setAcceptorCode(?string $acceptor_code): self
    {
        return tap($this, fn () => $this->acceptor_code = $acceptor_code);
    }
}
