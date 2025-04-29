<?php

namespace Ismailua\UblTrInvoice\Models\UblInvoice;

class Address
{
    public ?string $room = null;
    public ?string $streetName = null;
    public ?string $buildingName = null;
    public ?string $buildingNumber = null;
    public ?string $citySubdivisionName = null;
    public ?string $cityName = null;
    public ?string $postalZone = null;
    public ?string $region = null;
    public string $countryCode;
    public string $countryName;

    public function setRoom(string $room): self
    {
        $this->room = $room;
        return $this;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;
        return $this;
    }

    public function setBuildingName(string $buildingName): self
    {
        $this->buildingName = $buildingName;
        return $this;
    }

    public function setBuildingNumber(string $buildingNumber): self
    {
        $this->buildingNumber = $buildingNumber;
        return $this;
    }

    public function setCitySubdivisionName(string $citySubdivisionName): self
    {
        $this->citySubdivisionName = $citySubdivisionName;
        return $this;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;
        return $this;
    }

    public function setPostalZone(string $postalZone): self
    {
        $this->postalZone = $postalZone;
        return $this;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;
        return $this;
    }
}
