<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;
class Tax extends Model
{
    public float $taxAmount;
    public array $taxSubtotals = [];

    public function setTaxAmount(float $taxAmount): self
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    public function addTaxSubtotal(TaxSubtotal $taxSubtotal): self
    {
        $this->taxSubtotals[] = $taxSubtotal;
        return $this;
    }
}
