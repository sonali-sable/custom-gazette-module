<?php

namespace Drupal\custom_gazette_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GazetteController.
 */
class GazetteController extends ControllerBase {

  /**
   * Display content.
   */
  public function content(Request $request) {
    // Fetch data from The Gazette API.
    $url = 'https://www.thegazette.co.uk/all-notices/notice/data.json';
    $page = $request->query->get('page', 1);
    $resultsPerPage = 10;

    // Handle the self-signed certificate issue.
    $options = ['verify' => FALSE];
    $response = \Drupal::httpClient()->get("$url?results-page=$page", $options);
    $data = json_decode($response->getBody());

    // Process data and render HTML output.
    $output = '';
    foreach ($data as $notice) {
      $title = $notice->title;
      $publish_date = date('j F Y', strtotime($notice->publish_date));
      $content = $notice->content;

      // Construct HTML for each notice.
      $output .= "<h2><a href='#'>$title</a></h2>";
      $output .= "<p>Publish Date: $date</p>";
      $output .= "<div>$content</div>";
    }

    // Add pager.
    $output = [
        '#theme' => 'gazette_notices',
        '#notices' => $data,
      ];
  
      return $output;
  }
}
