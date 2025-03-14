<?php


namespace App\Service;

use Embed\Embed;

class UrlPreviewService
{
    public function fetchMetadata(string $url): array
    {
        $embed = new Embed();
        $info = $embed->get($url);

        return [
            'title' => $info->title,
            'description' => $info->description,
            'image' => $info->image,
            'url' => $info->url,
        ];
    }
}