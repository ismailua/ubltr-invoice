<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class TaxScheme
{
    public string $name;
    public string $taxTypeCode;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setTaxTypeCode(string $taxTypeCode): self
    {
        $this->taxTypeCode = $taxTypeCode;
        return $this;
    }
}
