<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class LegalMonetaryTotal
{
    public float $lineExtensionAmount;
    public float $taxExclusiveAmount;
    public float $taxInclusiveAmount;
    public float $allowanceTotalAmount = 0;
    public float $chargeTotalAmount = 0;
    public float $payableAmount;

    public function setLineExtensionAmount(float $lineExtensionAmount): self
    {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    public function setTaxExclusiveAmount(float $taxExclusiveAmount): self
    {
        $this->taxExclusiveAmount = $taxExclusiveAmount;
        return $this;
    }

    public function setTaxInclusiveAmount(float $taxInclusiveAmount): self
    {
        $this->taxInclusiveAmount = $taxInclusiveAmount;
        return $this;
    }

    public function setAllowanceTotalAmount(float $allowanceTotalAmount): self
    {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }

    public function setChargeTotalAmount(float $chargeTotalAmount): self
    {
        $this->chargeTotalAmount = $chargeTotalAmount;
        return $this;
    }

    public function setPayableAmount(float $payableAmount): self
    {
        $this->payableAmount = $payableAmount;
        return $this;
    }
}
