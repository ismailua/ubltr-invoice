<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;
class PartyTaxScheme extends Model
{
    public string $name;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}

