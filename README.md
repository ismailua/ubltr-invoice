# UBL-TR Invoice Generator for Laravel
A Laravel package for generating UBL-TR compliant XML invoices

## Installation

1. Install the package via Composer:
```bash
composer require ismailua/ubltr-invoice
```

2. Publish the configuration file:
```bash
php artisan vendor:publish --tag=config
```
## Usage

```php
use Ismailua\UblTrInvoice\Facades\UBLInvoice;
use Ismailua\UblTrInvoice\Models\UblInvoice\Invoice;
use Ismailua\UblTrInvoice\Models\UblInvoice\Party;
use Ismailua\UblTrInvoice\Models\UblInvoice\Address;
use Ismailua\UblTrInvoice\Models\UblInvoice\PartyIdentification;
use Ismailua\UblTrInvoice\Models\UblInvoice\PartyTaxScheme;
use Ismailua\UblTrInvoice\Models\UblInvoice\Contact;
use Ismailua\UblTrInvoice\Models\UblInvoice\Tax;
use Ismailua\UblTrInvoice\Models\UblInvoice\TaxSubtotal;
use Ismailua\UblTrInvoice\Models\UblInvoice\TaxScheme;
use Ismailua\UblTrInvoice\Models\UblInvoice\LegalMonetaryTotal;
use Ismailua\UblTrInvoice\Models\UblInvoice\InvoiceLine;
use Ismailua\UblTrInvoice\Models\UblInvoice\Item;
use Ismailua\UblTrInvoice\Models\UblInvoice\Price;

$invoice = new Invoice();
$invoice->id = 'TST2021000000002';
$invoice->issueDate = '2021-02-10';
$invoice->issueTime = '11:11:24';
$invoice->note = 'Yalnız Bir TL OnSekiz kuruş';
$invoice->lineCountNumeric = 1;

// Supplier Party
$supplier = new Party();
$supplier->addPartyIdentification((new PartyIdentification())->setId('1923001923')->setSchemeID('VKN'));
$supplier->addPartyIdentification((new PartyIdentification())->setId('1111111111111111')->setSchemeID('MERSISNO'));
$supplier->setPartyName('İsmail ÇAKIR');
$supplier->setPostalAddress((new Address())
    ->setRoom('19')
    ->setBuildingName('Test Binası')
    ->setBuildingNumber('23')
    ->setCitySubdivisionName('Kartal')
    ->setCityName('İstanbul')
    ->setCountryCode('TR')
    ->setCountryName('Türkiye'));
$supplier->setPartyTaxScheme((new PartyTaxScheme())->setName('Kartal Vergi Dairesi'));
$invoice->accountingSupplierParty = $supplier;

// Customer Party
$customer = new Party();
$customer->addPartyIdentification((new PartyIdentification())->setId('6090408038')->setSchemeID('VKN'));
$customer->setPartyName('FIRMA ELEKTRONİK TİCARET HİZMETLERİ ANONİM ŞİRKETİ');
$customer->setPostalAddress((new Address())
    ->setStreetName('Test')
    ->setCitySubdivisionName('Test')
    ->setCityName('Test')
    ->setCountryCode('TR')
    ->setCountryName('Türkiye'));
$customer->setPartyTaxScheme((new PartyTaxScheme())->setName('test vergi dairesi'));
$customer->setContact((new Contact())->setElectronicMail('test@test.com'));
$invoice->accountingCustomerParty = $customer;

// Tax Total
$tax = new Tax();
$tax->setTaxAmount(0.18);
$tax->addTaxSubtotal((new TaxSubtotal())
    ->setTaxableAmount(1)
    ->setTaxAmount(0.18)
    ->setPercent(18)
    ->setTaxScheme((new TaxScheme())->setName('KDV GERCEK')->setTaxTypeCode('0015')));
$invoice->taxTotal = $tax;

// Legal Monetary Total
$legalMonetaryTotal = new LegalMonetaryTotal();
$legalMonetaryTotal->setLineExtensionAmount(1);
$legalMonetaryTotal->setTaxExclusiveAmount(1);
$legalMonetaryTotal->setTaxInclusiveAmount(1.18);
$legalMonetaryTotal->setPayableAmount(1.18);
$invoice->legalMonetaryTotal = $legalMonetaryTotal;

// Invoice Line
$invoiceLine = new InvoiceLine();
$invoiceLine->setId('1');
$invoiceLine->setInvoicedQuantity(1);
$invoiceLine->setLineExtensionAmount(1);
$invoiceLine->setTaxTotal((new Tax())
    ->setTaxAmount(0.18)
    ->addTaxSubtotal((new TaxSubtotal())
        ->setTaxableAmount(1)
        ->setTaxAmount(0.18)
        ->setPercent(18)
        ->setTaxScheme((new TaxScheme())->setName('KDV GERCEK')->setTaxTypeCode('0015'))));
$invoiceLine->setItem((new Item())
    ->setDescription('test')
    ->setName('test')
    ->setSellersItemIdentification('test'));
$invoiceLine->setPrice((new Price())->setPriceAmount(1));
$invoice->invoiceLines = [$invoiceLine];

$xml = UBLInvoice::generate($invoice);
file_put_contents('invoice.xml', $xml);
```

## Configuration

The configuration file is located at `config/ubl-invoice.php`. You can modify default values such as currency and invoice type.

## Testing

Run the tests using:
```bash
vendor/bin/phpunit
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support
ismailua@gmail.com 
