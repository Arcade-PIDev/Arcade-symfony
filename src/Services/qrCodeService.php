<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Symfony\Component\HttpKernel\KernelInterface;

class qrCodeService
{
    protected $builder;
    private $appKernel;

    public function __construct(BuilderInterface $builder,KernelInterface $appKernel)
    {
        $this->builder = $builder;
        $this->appKernel = $appKernel;
    }

    public function qrcode($query)
    {
        $objDateTime = new \DateTime('NOW');

        $result=$this->builder
        ->data($query)
        ->encoding(new Encoding('UTF-8'))
        ->size(200)
        ->backgroundColor(new Color(251, 204, 209))
        ->build()
    ;

        $namePng = uniqid('', '') . '.png';

        $result->saveToFile( $this->appKernel->getProjectDir().'/public/eshop/qrCode/'.$namePng);

        return $result->getDataUri();
    }
}