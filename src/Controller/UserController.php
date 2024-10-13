<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    #[Route('/user/{id}/add-role', methods:['POST'])]
    public function addRole(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $newRole = $request->request->get('role');
        
        if (!in_array($newRole, ['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_CONSULTANT'])) {
            return $this->json(['message' => 'Invalid role'], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        $roles = $user->getRoles();
        if (!in_array($newRole, $roles)) {
            $roles[] = $newRole; 


        $user->setRoles(array_unique($roles));
        
        $em->flush();

        return $this->json(['message' => 'Role added successfully to the user'], JsonResponse::HTTP_OK);

        }
    }
}