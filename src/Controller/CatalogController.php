<?php

namespace App\Controller;

use App\Entity\Catalog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogController extends AbstractController
{

     /**
     * @Route("/import", name="catalog_import")
     */
    public function import() {

        $catalog = $_SERVER['DOCUMENT_ROOT'] . "/catalog.json";

        $json = file_get_contents($catalog);

        $data = json_decode($json, true);


        $catalog = new Catalog();

        $em = $this->getDoctrine()->getManager();
        $catalog->setIdCat(1);
        $catalog->setParentId('1');
        $catalog->setTitle('россия');
//            $catalog->setSlug('slug');

        $em->persist($catalog);
        $em->flush();


//        $this->buildTree($data);

        return $this->redirectToRoute('homepage');
    }

    private function buildTree($data, $pid = '0') {

        foreach ($data as $node) {

            $catalog = new Catalog();

            $em = $this->getDoctrine()->getManager();
            $catalog->setIdCat($node['id']);
            $catalog->setParentId($pid);
            $catalog->setTitle($node['title']);
//            $catalog->setSlug('slug');

            $em->persist($catalog);
            $em->flush();



//            $instance = Catalog::firstOrNew([
//                'parent_id' => $pid,
//                'id_cat' => $node['id']
//            ]);
//
//            $instance->fill([
//                'title' => $node['title'],
//                'slug' => SlugifyFacade::slugify($node['title'])
//            ]);
//
//            $instance->save();

            if (isset($node['children'])) {
                $this->buildTree($node['children'], $node['id']);
            }
        }
    }
}