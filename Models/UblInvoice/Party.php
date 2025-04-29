<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class Party
{
    public ?string $websiteUri = null;
    public array $partyIdentifications = [];
    public ?string $partyName = null;
    public Address $postalAddress;
    public ?PartyTaxScheme $partyTaxScheme = null;
    public ?Contact $contact = null;

    public function setWebsiteUri(?string $websiteUri): self
    {
        $this->websiteUri = $websiteUri;
        return $this;
    }

    public function addPartyIdentification(PartyIdentification $partyIdentification): self
    {
        $this->partyIdentifications[] = $partyIdentification;
        return $this;
    }

    public function setPartyName(?string $partyName): self
    {
        $this->partyName = $partyName;
        return $this;
    }

    public function setPostalAddress(Address $postalAddress): self
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    public function setPartyTaxScheme(?PartyTaxScheme $partyTaxScheme): self
    {
        $this->partyTaxScheme = $partyTaxScheme;
        return $this;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;
        return $this;
    }
}
