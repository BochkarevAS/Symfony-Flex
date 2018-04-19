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

        $this->buildTree($data);

        return $this->redirectToRoute('homepage');
    }

    private function buildTree($data, $pid = '0') {
        $em = $this->getDoctrine()->getManager();

        foreach ($data as $node) {

            $catalog = $this->getDoctrine()
                ->getRepository(Catalog::class)
                ->findOneBy([
                    'parentId' => $pid,
                    'idCat' => $node['id']
                ]);

            if (!$catalog) {
                $catalog = new Catalog();
                $catalog->setIdCat($node['id']);
                $catalog->setParentId($pid);
                $catalog->setTitle($node['title']);
                $catalog->setCreatedAt();
            } else {
                $catalog->setIdCat($node['id']);
                $catalog->setParentId($pid);
                $catalog->setTitle($node['title']);
                $catalog->setCreatedAt();
            }

            $em->persist($catalog);

            if (isset($node['children'])) {
                $this->buildTree($node['children'], $node['id']);
            }
        }

        $em->flush();
    }
}