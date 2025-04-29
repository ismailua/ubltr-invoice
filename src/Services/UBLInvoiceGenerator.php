<?php

namespace Ismailua\UblTrInvoice\Services;

use DOMDocument;
use Ismailua\UblTrInvoice\Models\UblInvoice\Invoice;
use Ismailua\UblTrInvoice\Models\UblInvoice\Party;

class UBLInvoiceGenerator
{
    public function generate(Invoice $invoice): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $root = $doc->createElementNS('urn:oasis:names:specification:ubl:schema:xsd:Invoice-2', 'Invoice');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ubltr', 'urn:oasis:names:specification:ubl:schema:xsd:TurkishCustomizationExtensionComponents');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $root->setAttribute('xsi:schemaLocation', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 UBL-Invoice-2.1.xsd');
        $doc->appendChild($root);

        $this->addElement($doc, $root, 'cbc:UBLVersionID', $invoice->ublVersionId);
        $this->addElement($doc, $root, 'cbc:CustomizationID', $invoice->customizationId);
        $this->addElement($doc, $root, 'cbc:ProfileID', $invoice->profileId);
        $this->addElement($doc, $root, 'cbc:ID', $invoice->id);
        $this->addElement($doc, $root, 'cbc:CopyIndicator', $invoice->copyIndicator ? 'true' : 'false');
        $this->addElement($doc, $root, 'cbc:UUID', $invoice->uuid);
        $this->addElement($doc, $root, 'cbc:IssueDate', $invoice->issueDate);
        if ($invoice->issueTime) {
            $this->addElement($doc, $root, 'cbc:IssueTime', $invoice->issueTime);
        }
        $this->addElement($doc, $root, 'cbc:InvoiceTypeCode', $invoice->invoiceTypeCode);
        if ($invoice->note) {
            $this->addElement($doc, $root, 'cbc:Note', $invoice->note);
        }
        $this->addElement($doc, $root, 'cbc:DocumentCurrencyCode', $invoice->documentCurrencyCode, [
            'listAgencyName' => 'United Nations Economic Commission for Europe',
            'listID' => 'ISO 4217 Alpha',
            'listName' => 'Currency',
            'listVersionID' => '2001'
        ]);
        $this->addElement($doc, $root, 'cbc:LineCountNumeric', $invoice->lineCountNumeric);

        // Add AccountingSupplierParty
        $supplierParty = $doc->createElement('cac:AccountingSupplierParty');
        $party = $doc->createElement('cac:Party');
        $this->addPartyDetails($doc, $party, $invoice->accountingSupplierParty);
        $supplierParty->appendChild($party);
        $root->appendChild($supplierParty);

        // Add AccountingCustomerParty
        $customerParty = $doc->createElement('cac:AccountingCustomerParty');
        $party = $doc->createElement('cac:Party');
        $this->addPartyDetails($doc, $party, $invoice->accountingCustomerParty);
        $customerParty->appendChild($party);
        $root->appendChild($customerParty);

        // Add TaxTotal
        $taxTotal = $doc->createElement('cac:TaxTotal');
        $this->addElement($doc, $taxTotal, 'cbc:TaxAmount', $invoice->taxTotal->taxAmount, ['currencyID' => 'TRY']);
        foreach ($invoice->taxTotal->taxSubtotals as $subtotal) {
            $taxSubtotal = $doc->createElement('cac:TaxSubtotal');
            $this->addElement($doc, $taxSubtotal, 'cbc:TaxableAmount', $subtotal->taxableAmount, ['currencyID' => 'TRY']);
            $this->addElement($doc, $taxSubtotal, 'cbc:TaxAmount', $subtotal->taxAmount, ['currencyID' => 'TRY']);
            $this->addElement($doc, $taxSubtotal, 'cbc:Percent', $subtotal->percent);
            $taxCategory = $doc->createElement('cac:TaxCategory');
            $taxScheme = $doc->createElement('cac:TaxScheme');
            $this->addElement($doc, $taxScheme, 'cbc:Name', $subtotal->taxScheme->name);
            $this->addElement($doc, $taxScheme, 'cbc:TaxTypeCode', $subtotal->taxScheme->taxTypeCode);
            $taxCategory->appendChild($taxScheme);
            $taxSubtotal->appendChild($taxCategory);
            $taxTotal->appendChild($taxSubtotal);
        }
        $root->appendChild($taxTotal);

        // Add LegalMonetaryTotal
        $legalMonetary = $doc->createElement('cac:LegalMonetaryTotal');
        $this->addElement($doc, $legalMonetary, 'cbc:LineExtensionAmount', $invoice->legalMonetaryTotal->lineExtensionAmount, ['currencyID' => 'TRY']);
        $this->addElement($doc, $legalMonetary, 'cbc:TaxExclusiveAmount', $invoice->legalMonetaryTotal->taxExclusiveAmount, ['currencyID' => 'TRY']);
        $this->addElement($doc, $legalMonetary, 'cbc:TaxInclusiveAmount', $invoice->legalMonetaryTotal->taxInclusiveAmount, ['currencyID' => 'TRY']);
        $this->addElement($doc, $legalMonetary, 'cbc:AllowanceTotalAmount', $invoice->legalMonetaryTotal->allowanceTotalAmount, ['currencyID' => 'TRY']);
        $this->addElement($doc, $legalMonetary, 'cbc:ChargeTotalAmount', $invoice->legalMonetaryTotal->chargeTotalAmount, ['currencyID' => 'TRY']);
        $this->addElement($doc, $legalMonetary, 'cbc:PayableAmount', $invoice->legalMonetaryTotal->payableAmount, ['currencyID' => 'TRY']);
        $root->appendChild($legalMonetary);

        // Add InvoiceLines
        foreach ($invoice->invoiceLines as $line) {
            $invoiceLine = $doc->createElement('cac:InvoiceLine');
            $this->addElement($doc, $invoiceLine, 'cbc:ID', $line->id);
            if ($line->note) {
                $this->addElement($doc, $invoiceLine, 'cbc:Note', $line->note);
            }
            $this->addElement($doc, $invoiceLine, 'cbc:InvoicedQuantity', $line->invoicedQuantity, ['unitCode' => $line->unitCode]);
            $this->addElement($doc, $invoiceLine, 'cbc:LineExtensionAmount', $line->lineExtensionAmount, ['currencyID' => 'TRY']);

            $taxTotal = $doc->createElement('cac:TaxTotal');
            $this->addElement($doc, $taxTotal, 'cbc:TaxAmount', $line->taxTotal->taxAmount, ['currencyID' => 'TRY']);
            foreach ($line->taxTotal->taxSubtotals as $subtotal) {
                $taxSubtotal = $doc->createElement('cac:TaxSubtotal');
                $this->addElement($doc, $taxSubtotal, 'cbc:TaxableAmount', $subtotal->taxableAmount, ['currencyID' => 'TRY']);
                $this->addElement($doc, $taxSubtotal, 'cbc:TaxAmount', $subtotal->taxAmount, ['currencyID' => 'TRY']);
                $this->addElement($doc, $taxSubtotal, 'cbc:Percent', $subtotal->percent);
                $taxCategory = $doc->createElement('cac:TaxCategory');
                $taxScheme = $doc->createElement('cac:TaxScheme');
                $this->addElement($doc, $taxScheme, 'cbc:Name', $subtotal->taxScheme->name);
                $this->addElement($doc, $taxScheme, 'cbc:TaxTypeCode', $subtotal->taxScheme->taxTypeCode);
                $taxCategory->appendChild($taxScheme);
                $taxSubtotal->appendChild($taxCategory);
                $taxTotal->appendChild($taxSubtotal);
            }
            $invoiceLine->appendChild($taxTotal);

            $item = $doc->createElement('cac:Item');
            if ($line->item->description) {
                $this->addElement($doc, $item, 'cbc:Description', $line->item->description);
            }
            $this->addElement($doc, $item, 'cbc:Name', $line->item->name);
            $sellersItem = $doc->createElement('cac:SellersItemIdentification');
            $this->addElement($doc, $sellersItem, 'cbc:ID', $line->item->sellersItemIdentification);
            $item->appendChild($sellersItem);
            $invoiceLine->appendChild($item);

            $price = $doc->createElement('cac:Price');
            $this->addElement($doc, $price, 'cbc:PriceAmount', $line->price->priceAmount, ['currencyID' => 'TRY']);
            $invoiceLine->appendChild($price);

            $root->appendChild($invoiceLine);
        }

        return $doc->saveXML();
    }

    private function addElement(DOMDocument $doc, $parent, string $name, $value, array $attributes = []): void
    {
        $element = $doc->createElement($name, htmlspecialchars((string)$value));
        foreach ($attributes as $key => $val) {
            $element->setAttribute($key, $val);
        }
        $parent->appendChild($element);
    }

    private function addPartyDetails(DOMDocument $doc, $party, Party $partyData): void
    {
        if ($partyData->websiteUri) {
            $this->addElement($doc, $party, 'cbc:WebsiteURI', $partyData->websiteUri);
        }

        foreach ($partyData->partyIdentifications as $identification) {
            $partyIdentification = $doc->createElement('cac:PartyIdentification');
            $this->addElement($doc, $partyIdentification, 'cbc:ID', $identification->id, ['schemeID' => $identification->schemeID]);
            $party->appendChild($partyIdentification);
        }

        if ($partyData->partyName) {
            $partyName = $doc->createElement('cac:PartyName');
            $this->addElement($doc, $partyName, 'cbc:Name', $partyData->partyName);
            $party->appendChild($partyName);
        }

        $postalAddress = $doc->createElement('cac:PostalAddress');
        if ($partyData->postalAddress->room) {
            $this->addElement($doc, $postalAddress, 'cbc:Room', $partyData->postalAddress->room);
        }
        if ($partyData->postalAddress->streetName) {
            $this->addElement($doc, $postalAddress, 'cbc:StreetName', $partyData->postalAddress->streetName);
        }
        if ($partyData->postalAddress->buildingName) {
            $this->addElement($doc, $postalAddress, 'cbc:BuildingName', $partyData->postalAddress->buildingName);
        }
        if ($partyData->postalAddress->buildingNumber) {
            $this->addElement($doc, $postalAddress, 'cbc:BuildingNumber', $partyData->postalAddress->buildingNumber);
        }
        if ($partyData->postalAddress->citySubdivisionName) {
            $this->addElement($doc, $postalAddress, 'cbc:CitySubdivisionName', $partyData->postalAddress->citySubdivisionName);
        }
        if ($partyData->postalAddress->cityName) {
            $this->addElement($doc, $postalAddress, 'cbc:CityName', $partyData->postalAddress->cityName);
        }
        if ($partyData->postalAddress->postalZone) {
            $this->addElement($doc, $postalAddress, 'cbc:PostalZone', $partyData->postalAddress->postalZone);
        }
        if ($partyData->postalAddress->region) {
            $this->addElement($doc, $postalAddress, 'cbc:Region', $partyData->postalAddress->region);
        }
        $country = $doc->createElement('cac:Country');
        $this->addElement($doc, $country, 'cbc:IdentificationCode', $partyData->postalAddress->countryCode);
        $this->addElement($doc, $country, 'cbc:Name', $partyData->postalAddress->countryName);
        $postalAddress->appendChild($country);
        $party->appendChild($postalAddress);

        if ($partyData->partyTaxScheme) {
            $partyTaxScheme = $doc->createElement('cac:PartyTaxScheme');
            $taxScheme = $doc->createElement('cac:TaxScheme');
            $this->addElement($doc, $taxScheme, 'cbc:Name', $partyData->partyTaxScheme->name);
            $partyTaxScheme->appendChild($taxScheme);
            $party->appendChild($partyTaxScheme);
        }

        if ($partyData->contact) {
            $contact = $doc->createElement('cac:Contact');
            if ($partyData->contact->telephone) {
                $this->addElement($doc, $contact, 'cbc:Telephone', $partyData->contact->telephone);
            }
            if ($partyData->contact->telefax) {
                $this->addElement($doc, $contact, 'cbc:Telefax', $partyData->contact->telefax);
            }
            if ($partyData->contact->electronicMail) {
                $this->addElement($doc, $contact, 'cbc:ElectronicMail', $partyData->contact->electronicMail);
            }
            $party->appendChild($contact);
        }
    }
}
