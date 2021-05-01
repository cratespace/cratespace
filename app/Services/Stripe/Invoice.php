<?php

namespace App\Services\Stripe;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\View as ViewContract;

class Invoice extends Resource
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'invoices';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = [
        'customer',
        'auto_advance',
        'collection_method',
        'description',
        'metadata',
    ];

    /**
     * Get a Carbon date for the invoice.
     *
     * @param \DateTimeZone|string $timezone
     *
     * @return \Carbon\Carbon
     */
    public function date($timezone = null): Carbon
    {
        $carbon = Carbon::createFromTimestampUTC(
            $this->resource->created ?? $this->resource->date
        );

        return $timezone ? $carbon->setTimezone($timezone) : $carbon;
    }

    /**
     * Get the View instance for the invoice.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(array $data): ViewContract
    {
        return View::make('billing.receipt', array_merge($data, [
            'invoice' => $this,
        ]));
    }

    /**
     * Capture the invoice as a PDF and return the raw bytes.
     *
     * @param array $data
     *
     * @return string
     */
    public function pdf(array $data)
    {
        if (! defined('DOMPDF_ENABLE_AUTOLOAD')) {
            define('DOMPDF_ENABLE_AUTOLOAD', false);
        }

        $options = new Options();
        $options->setChroot(base_path());

        $dompdf = new Dompdf($options);
        $dompdf->setPaper(config('billing.paper', 'letter'));
        $dompdf->loadHtml($this->view($data)->render());
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Create an invoice download response.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download(array $data)
    {
        $filename = $data['product'] . '_' . $this->date()->month . '_' . $this->date()->year;

        return $this->downloadAs($filename, $data);
    }

    /**
     * Create an invoice download response with a specific filename.
     *
     * @param string $filename
     * @param array  $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadAs(string $filename, array $data): Response
    {
        return new Response($this->pdf($data), 200, [
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => 'application/pdf',
            'X-Vapor-Base64-Encode' => 'True',
        ]);
    }

    /**
     * Void the Stripe invoice.
     *
     * @param array $options
     *
     * @return \App\Services\Stripe\Invoice
     */
    public function void(array $options = []): Invoice
    {
        $this->resource = $this->resource->voidInvoice($options);

        return $this;
    }
}
