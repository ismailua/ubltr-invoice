<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public ?string $telephone = null;
    public ?string $telefax = null;
    public ?string $electronicMail = null;

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setTelefax(string $telefax): self
    {
        $this->telefax = $telefax;
        return $this;
    }

    public function setElectronicMail(string $electronicMail): self
    {
        $this->electronicMail = $electronicMail;
        return $this;
    }
}
