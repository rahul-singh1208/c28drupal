<?php
namespace Drupal\rahul_axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends ControllerBase
{
    public function getnodedetails($apikey, $nid)
    {

        $siteapi_key = \Drupal::config('rahul_axelerant.settings')->get('siteapi_key');

        if ($apikey == $siteapi_key) {
            $node = Node::load($nid);
            if (!empty($node) && ($node->getType()=='page')) {
                $title = $node->getTitle();
                $body = $node->get('body')->getValue()[0]['value'];
                $response['title'] = $title;
                $response['body'] = $body;
                return new JsonResponse($response);

            } else {
                return new JsonResponse(array('error' => 'Invalid Node ID access denied'));
            }

        } else {
            return new JsonResponse(array('error' => 'Invalid Site API Key access denied'));
        }

    }
}
