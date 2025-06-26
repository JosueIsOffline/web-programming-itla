<?php

namespace App\Services;

class NewsApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {
    $url = 'https://techcrunch.com/wp-json/wp/v2/posts';

    $res = @file_get_contents($url);

    $data = json_decode($res, true);

    $news = [];

    foreach ($data as $post) {
      $news[] = [
        'title' => html_entity_decode(strip_tags($post['title']['rendered'])),
        'excerpt' => strip_tags($post['excerpt']['rendered']),
        'link' => $post['link'],
        'featured_image' => $post['jetpack_featured_media_url'],
        'author' => $post['yoast_head_json']['author'],
        'date' => $post['modified'],
        'reading_time' => $post['yoast_head_json']['twitter_misc']['Est. reading time']
      ];
    }

    return $news;
  }
}
