<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class Price
{
    public float $priceAmount;

    public function setPriceAmount(float $priceAmount): self
    {
        $this->priceAmount = $priceAmount;
        return $this;
    }
}
