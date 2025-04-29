<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    public string $id;
    public ?string $note = null;
    public float $invoicedQuantity;
    public string $unitCode = 'NIU';
    public float $lineExtensionAmount;
    public Tax $taxTotal;
    public Item $item;
    public Price $price;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function setInvoicedQuantity(float $invoicedQuantity): self
    {
        $this->invoicedQuantity = $invoicedQuantity;
        return $this;
    }

    public function setUnitCode(string $unitCode): self
    {
        $this->unitCode = $unitCode;
        return $this;
    }

    public function setLineExtensionAmount(float $lineExtensionAmount): self
    {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    public function setTaxTotal(Tax $taxTotal): self
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    public function setItem(Item $item): self
    {
        $this->item = $item;
        return $this;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;
        return $this;
    }
}
