<?php

namespace App\Services;

use barcode_generator;
use Exception;

require_once app_path('Libraries/barcode.php');

class BarcodeService
{
    /**
     * Gera um código de barras usando o barcode.php do KreativeKorp.
     *
     * @param string $code O código para gerar o barcode.
     * @param string $type O tipo do código de barras (ex.: "code128", "ean13", "upca").
     * @param int $width Largura do código de barras.
     * @param int $height Altura do código de barras.
     * @param bool $returnAsBase64 Retornar a imagem como Base64.
     * @return string Caminho para o arquivo gerado ou Base64 da imagem.
     */
    public function generate(string $code, string $type = 'code128', int $width = 2, int $height = 50, bool $returnAsBase64 = true)
    {
        try {
            // Inicializa o gerador de barcode
            $barcode = new barcode_generator();

            // Gera o código de barras como imagem
            // $image = $barcode->render_svg('ean-13', $code, [            ]);

            ob_start(); // Inicia o buffer de saída
            $barcode->output_image('jpg', $type, $code, [ 'sf' => 4, 'ts' => 38, 'th' => 20         ]);
            $image = ob_get_clean(); // Captura os dados binários gerados

            if ($returnAsBase64) {
                // Retorna a imagem como Base64
                return 'data:image/jpeg;base64,' . base64_encode($image);
            }

           return  $image;
        } catch (Exception $e) {
            return 'Erro ao gerar código de barras: ' . $e->getMessage();
        }
    }
}
