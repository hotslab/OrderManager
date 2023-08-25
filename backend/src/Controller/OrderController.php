<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends AbstractController
{
    public function listOrders(Request $request): JsonResponse
    {
        $orders = $this->getDoctrine()->getManager()->getRepository(Order::class);
        $results = $orders->findAllPaginatedOrders(
            [ 'customer' => $request->query->get('customer'), 'status' => $request->query->get('status')],
            $request->query->get('page'), $request->query->get('size')
        );
        return $this->json($results, 200);
    }

    public function cancelOrder(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $orderRepo = $this->getDoctrine()->getManager()->getRepository(Order::class);
        $canceledOrderExists = $orderRepo->find($id);
        if ($canceledOrderExists && $canceledOrderExists->getStatus() !== 'cancelled') {
            $orderRepo->cancelOrder($canceledOrderExists);
            return $this->json(['message' => 'Order #'.$id.' for '. $canceledOrderExists->getCustomer().' canceled.'], 200);
        }
        return $this->json(['message' => 'Order #'.$id. ' was cancelled already or does not exist.'], 404);
    }
}
