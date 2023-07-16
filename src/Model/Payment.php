<?php

namespace JalalLinuX\Tomanpay\Model;

use Illuminate\Support\Carbon;
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

    public function detail(string $uuid): Payment
    {
        $response = $this->client()->get("payments/{$uuid}")->json();

        return self::fromArray($response);
    }

    public static function fromArray(array $array): self
    {
        $payment = new self;
        foreach ($array as $k => $v) {
            $method = 'set'.ucfirst(Str::camel($k));
//            if (method_exists($payment, $method)) {
                $payment->{$method}($v);
//            }
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
        return !is_null($this->verified_at) ? Carbon::parse($this->verified_at) : null;
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
        throw_if(!Str::isUuid($uuid), new \Exception('Payment uuid must be a valid UUID 4 format.'));

        return tap($this, fn() => $this->uuid = $uuid);
    }

    public function setAmount(int $amount): self
    {
        return tap($this, fn() => $this->amount = $amount);
    }

    public function setTomanWage(int $toman_wage): self
    {
        return tap($this, fn() => $this->toman_wage = $toman_wage);
    }

    public function setWage(int $wage): self
    {
        return tap($this, fn() => $this->wage = $wage);
    }

    public function setShaparakWage(int $shaparak_wage): self
    {
        return tap($this, fn() => $this->shaparak_wage = $shaparak_wage);
    }

    public function setStatus(int $status): self
    {
        return tap($this, fn() => $this->status = $status);
    }

    public function setPsp(string $psp): self
    {
        return tap($this, fn() => $this->psp = $psp);
    }

    public function setTerminalNumber(string $terminal_number): self
    {
        return tap($this, fn() => $this->terminal_number = $terminal_number);
    }

    public function setCreatedAt(string $created_at): self
    {
        return tap($this, fn() => $this->created_at = $created_at);
    }

    public function setCheckNationalId(bool $check_national_id): self
    {
        return tap($this, fn() => $this->check_national_id = $check_national_id);
    }

    public function setMobileNumber(?string $mobile_number): self
    {
        return tap($this, fn() => $this->mobile_number = $mobile_number);
    }

    public function setCallbackUrl(?string $callback_url): self
    {
        return tap($this, fn() => $this->callback_url = $callback_url);
    }

    public function setTrackerId(?string $tracker_id): self
    {
        return tap($this, fn() => $this->tracker_id = $tracker_id);
    }

    public function setVerifiedAt(?string $verified_at): self
    {
        return tap($this, fn() => $this->verified_at = $verified_at);
    }

    public function setTraceNumber(?string $trace_number): self
    {
        return tap($this, fn() => $this->trace_number = $trace_number);
    }

    public function setReferenceNumber(?string $reference_number): self
    {
        return tap($this, fn() => $this->reference_number = $reference_number);
    }

    public function setDigitalReceiptNumber(?string $digital_receipt_number): self
    {
        return tap($this, fn() => $this->digital_receipt_number = $digital_receipt_number);
    }

    public function setMaskedPaidCardNumber(?string $masked_paid_card_number): self
    {
        return tap($this, fn() => $this->masked_paid_card_number = $masked_paid_card_number);
    }

    public function setAcceptorCode(?string $acceptor_code): self
    {
        return tap($this, fn() => $this->acceptor_code = $acceptor_code);
    }
}
