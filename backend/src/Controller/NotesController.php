<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Note;
/**
 * @Route("/notes")
 */
class NotesController extends AbstractController {
    /**
     * @Route("/{page}", name="note_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request) {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(Note::class);
        $items = $repository->findAll();

        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (Note $item) {
                    return $this->generateUrl('note_by_id', ['id' => $item->getId()]);
                }, $items)
            ]
        );
    }

    /**
     * @Route("/note/{id}", name="note_by_id", requirements={"id"="\d+"})
     */
    public function note($id) {
        return $this->json(
            $this->getDoctrine()->getRepository(Note::class)->find($id)
        );
    }

    /**
     * @Route("/add", name="note_add", methods={"POST"})
     */
    public function add(Request $request) {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        $note = $serializer->deserialize($request->getContent(), Note::class, 'json');
        $en = $this->getDoctrine()->getManager();
        $en->persist($note);
        $en->flush();

        return $this->json($note);
    }
}