<?php

/**
 * Comprime uma imagem, se possível, e a salva no destino especificado.
 * @param string $source O caminho da imagem de origem.
 * @param string $destination O caminho onde a imagem comprimida será salva.
 * @param int $quality A qualidade da compressão (de 0 a 100).
 * @return string O caminho da imagem comprimida ou do arquivo original em caso de erro.
 */
function compressImage(string $source, string $destination, int $quality = 80): string
{
    // Verifica se a função getimagesize() retornou informações da imagem
    $info = getimagesize($source);
    if ($info === false) {
        // Se getimagesize falhar, retorne o arquivo original sem compressão
        copy($source, $destination);
        return $destination;
    }

    // Comprime a imagem de acordo com o tipo MIME
    $image = createImageFromType($info['mime'], $source);
    if ($image === false) {
        // Se não for possível criar a imagem, retorne o arquivo original sem compressão
        copy($source, $destination);
        return $destination;
    }

    // Salva a imagem comprimida
    saveCompressedImage($image, $destination, $info['mime'], $quality);

    // Libera a memória utilizada pela imagem
    imagedestroy($image);

    return $destination;
}

/**
 * Cria uma imagem a partir do tipo MIME e do caminho do arquivo.
 * @param string $mime O tipo MIME da imagem.
 * @param string $source O caminho do arquivo de origem.
 * @return resource|false Retorna a imagem criada ou false em caso de erro.
 */
function createImageFromType(string $mime, string $source)
{
    switch ($mime) {
        case 'image/jpeg':
            return imagecreatefromjpeg($source);
        case 'image/png':
            return imagecreatefrompng($source);
        default:
            return false;
    }
}

/**
 * Salva a imagem comprimida no destino especificado.
 * @param resource $image A imagem a ser salva.
 * @param string $destination O caminho onde a imagem será salva.
 * @param string $mime O tipo MIME da imagem.
 * @param int $quality A qualidade da compressão (de 0 a 100).
 * @return void
 */
function saveCompressedImage($image, string $destination, string $mime, int $quality)
{
    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($image, $destination, $quality);
            break;
        case 'image/png':
            imagepng($image, $destination, floor($quality / 10));
            break;
        default:
            // Se o tipo MIME não for suportado, salva o arquivo original
            copy($source, $destination);
    }
}

?>
