<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class PartyTaxScheme
{
    public string $name;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}

