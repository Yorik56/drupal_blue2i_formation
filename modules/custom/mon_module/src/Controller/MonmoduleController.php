<?php

namespace Drupal\mon_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class MonmoduleController extends \Drupal\Core\Controller\ControllerBase {

    public function description() {
        $build = array(
            '#type' => 'markup',
            '#markup' => t('Hello world !'),
        );

        return $build;
    }

    public function requests() {

        // Requête sur tout les noeuds
        $query = \Drupal::entityQuery('node');
        $nids = $query->execute();

        // Requête sur tout les utilisateur
        $query = \Drupal::entityQuery('user');
        $uids = $query->execute();
        // Requête sur tout les commentaires
        $query = \Drupal::entityQuery('comment');
        $cids = $query->execute();

        // Filtre de requête sur tout les noeuds
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'horloge')
            // ->condition('uid', 1)
            // ->condition('title', 'Webmaster', 'CONTAINS')
            ->condition('field_horloge_mecanique.value', 1);
        $filtered_nids = $query->execute();

        // dsm($nids);

        $markup = 'Node ids: ' . implode(', ', $nids);
        $markup .= '<br/>User ids:' . implode(', ', $uids);
        $markup .= '<br/>Comment ids:' . implode(', ', $cids);
        $markup .= '<br/>Filtered node ids:' . implode(', ', $filtered_nids);

        // Champ unique
        $markup .= '</br><br/>'; // (Saut de ligne)
        $node = Node::load(reset($filtered_nids));
        $markup .= 'Corps du premier noeud:' . $node->body->value;

        $node->set('title', $node->title->value . '*');
        $node->save();
        $markup .= 'Titre du premier noeud: ' . $node->title->value;


        //  Champs multiples
        $nodes = Node::loadMultiple($filtered_nids);
        $markup .= '</br>';
        foreach ($nodes as $node) {
            $markup .= '</br>';
            $markup .= 'Date de fabrication (nid: ' . $node->nid->value .'): ' . $node->field_date_d_ajout->value;
        }
        
        $result = db_query('SELECT field_photo_du_produit_alt '
                 . 'FROM { node__field_photo_du_produit }' 
                 . 'WHERE entity_id = :nid', array(':nid' => 2 ));
        foreach ($result as $record) {
            $markup .= '<br/><br/>Texte alternatif: ' . $record->field_photo_du_produit_alt;
        }

        $build = array(
            '#type' => 'markup',
            '#markup' => $markup,
        );

        return $build;
    }
}