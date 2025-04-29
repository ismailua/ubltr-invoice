<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;
use Illuminate\Database\Eloquent\Model;
class Price extends Model
{
    public float $priceAmount;

    public function setPriceAmount(float $priceAmount): self
    {
        $this->priceAmount = $priceAmount;
        return $this;
    }
}
