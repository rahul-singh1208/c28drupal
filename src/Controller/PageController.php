<?php
/**
@file
Contains \Drupal\rahul_axelerant\Controller\PageController.
 */
namespace Drupal\rahul_axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use \Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends ControllerBase
{
    public function getnodedetails($apikey, $nid)
    {

        $siteapi_key = \Drupal::config('rahul_axelerant.settings')->get('siteapi_key');

        if ($apikey == $siteapi_key) {
            $query = \Drupal::entityQuery('node')
                ->condition('nid', $nid)
                ->condition('type', 'page', '=')
                ->execute();

            if (empty($query)) {
                return new JsonResponse(array('error' => 'Invalid Node ID access denied'));
            } else {
                $node = Node::load($nid);
                $title = $node->getTitle();
                $body = $node->get('body')->getValue()[0]['value'];
                $response['title'] = $title;
                $response['body'] = $body;
                return new JsonResponse($response);
            }

        } else {
            return new JsonResponse(array('error' => 'Invalid Site API Key access denied'));
        }

    }
}
