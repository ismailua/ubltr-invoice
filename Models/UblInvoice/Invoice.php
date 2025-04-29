<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    public string $ublVersionId = '2.1';
    public string $customizationId = 'TR1.2';
    public string $profileId = 'TEMELFATURA';
    public string $id;
    public bool $copyIndicator = false;
    public string $uuid;
    public string $issueDate;
    public ?string $issueTime = null;
    public string $invoiceTypeCode = 'SATIS';
    public ?string $note = null;
    public string $documentCurrencyCode = 'TRY';
    public int $lineCountNumeric;
    public Party $accountingSupplierParty;
    public Party $accountingCustomerParty;
    public Tax $taxTotal;
    public LegalMonetaryTotal $legalMonetaryTotal;
    public array $invoiceLines = [];

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }
}
