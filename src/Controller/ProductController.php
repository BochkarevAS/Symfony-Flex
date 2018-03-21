<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductController extends Controller
{

    /**
     * @Route("/product", name="product_show")
     */
    public function showProduct(Request $request) {

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $product = $form->getData();
            $product->setPrice($product->getPrice());
            $product->setName($product->getName());

            $em->persist($product);
            $em->flush();

//            if ($request->isXmlHttpRequest()) {
//                return $this->render('catalog/products_render.html.twig', [
//                    'product' => $product
//                ]);
//            }

            $this->addFlash('Success', 'Created!');

            return $this->redirectToRoute('product_show');
        }

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

//        if ($request->isXmlHttpRequest()) {
//            $html = $this->renderView('catalog/products_render.html.twig', [
//                'form' => $form->createView()
//            ]);
//
//            return new Response($html, 400);
//        }

        return $this->render('catalog/products.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function deleteProduct($id) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $em->remove($product);
        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/product/new", name="product_new", methods={"POST"})
     */
    public function newProduct(Request $request) {

        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        $form = $this->createForm(ProductType::class);
        $form->submit($data);

        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);
            $json = $this->get('serializer')->serialize(['errors' => $errors], 'json');

            return new JsonResponse($json, 400, [], true);
        }

        return new Response(null, 204);

//        $product = new Product();
//        $product->setName($name);
//        $product->setPrice($price);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($product);
//        $em->flush();
//
//        return new Response('Created!');
    }

    private function getErrorsFromForm(FormInterface $form) {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}