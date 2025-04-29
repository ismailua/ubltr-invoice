<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;
class TaxSubtotal extends Model
{
    public float $taxableAmount;
    public float $taxAmount;
    public float $percent;
    public TaxScheme $taxScheme;

    public function setTaxableAmount(float $taxableAmount): self
    {
        $this->taxableAmount = $taxableAmount;
        return $this;
    }

    public function setTaxAmount(float $taxAmount): self
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    public function setPercent(float $percent): self
    {
        $this->percent = $percent;
        return $this;
    }

    public function setTaxScheme(TaxScheme $taxScheme): self
    {
        $this->taxScheme = $taxScheme;
        return $this;
    }
}
