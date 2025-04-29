<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class PartyIdentification
{
    public string $id;
    public string $schemeID;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setSchemeID(string $schemeID): self
    {
        $this->schemeID = $schemeID;
        return $this;
    }
}
