<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomFormType;
use App\Repository\RoomRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    private $roomRepository;
    private $em;
    public function __construct(RoomRepository $roomRepository, EntityManagerInterface $em)
    {
        $this->roomRepository = $roomRepository;
        $this->em = $em;
    }

    #[Route('/homepage', methods: ['GET'], name: 'homepage')]
    public function index(): Response
    {
        $rooms = $this->roomRepository->findAll();
        return $this->render('main/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
    #[Route('/rooms/{id}', methods: ['GET'], name: 'rooms')]
    public function getRoom($id): Response
    {   $isMember=false;
        $room = $this->roomRepository->find($id);
        $user = $this->getUser();
        if ($room->getMembers()->contains($user)){
            $isMember=true;
        }
        return $this->render('main/room.html.twig', [
            'room' => $room,
            'isMember' => $isMember
        ]);
    }

    #[Route('/addRoom', methods: ['GET', 'POST'], name: 'add_room')]
    public function addRoom(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomFormType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newRoom = $form->getData();
            $newRoom->setOwner($this->getUser());
            $currentTimestamp = new DateTimeImmutable();
            $newRoom->setCreatedAt($currentTimestamp);
            $this->em->persist($newRoom);
            $this->em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('main/add_room.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('join/{roomId}', methods: ['POST'], name: 'join_room')]
    public function joinRoom($roomId): Response
    {
            $room = $this->roomRepository->find($roomId);
            $user = $this->getUser();
            if (!$room->getMembers()->contains($user)){
                $room->addMember($user);
                $this->em->flush();
                return $this->redirectToRoute('homepage');
            }
            else{
                return $this->redirectToRoute('homepage');
            }   
    }

    #[Route('/chat/{roomId}', methods: ['GET'], name: 'chat_room')]
    public function chat($roomId): Response
    {
        $room = $this->roomRepository->find($roomId);
        $user = $this->getUser();

        if ($room->getMembers()->contains($user)){
            return $this->render('main/chat.html.twig');
        }
        else{
            return $this->redirectToRoute('homepage');
        } 
        
    }
}
