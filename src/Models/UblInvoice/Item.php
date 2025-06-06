<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public ?string $description = null;
    public string $name;
    public string $sellersItemIdentification;

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSellersItemIdentification(string $sellersItemIdentification): self
    {
        $this->sellersItemIdentification = $sellersItemIdentification;
        return $this;
    }
}
