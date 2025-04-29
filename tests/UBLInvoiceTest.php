<?php

namespace Ismailua\UblTrInvoice\Tests;

use Orchestra\Testbench\TestCase;
use Ismailua\UblTrInvoice\Facades\UBLInvoice;
use Ismailua\UblTrInvoice\Models\UblInvoice\Invoice;
use Ismailua\UblTrInvoice\UBLInvoiceServiceProvider;

class UBLInvoiceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [UBLInvoiceServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'UBLInvoice' => UBLInvoice::class,
        ];
    }

    public function testCanGenerateInvoiceXml()
    {
        $invoice = new Invoice();
        $invoice->id = 'TST2021000000002';
        $invoice->issueDate = '2021-02-10';
        $invoice->lineCountNumeric = 1;

        $xml = UBLInvoice::generate($invoice);

        $this->assertStringContainsString('<cbc:ID>TST2021000000002</cbc:ID>', $xml);
        $this->assertStringContainsString('<cbc:IssueDate>2021-02-10</cbc:IssueDate>', $xml);
        $this->assertStringContainsString('urn:oasis:names:specification:ubl:schema:xsd:Invoice-2', $xml);
    }
}
