<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
/**
 * @Route("/notes")
 */
class NotesController extends AbstractController {
    private const NOTES = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello world!'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post!'
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'This is the last example'
        ],
    ];
    /**
     * @Route("/{page}", name="note_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request) {
        $limit = $request->get('limit', 10);

        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function ($item) {
                    return $this->generateUrl('note_by_slug', ['slug' => $item['slug']]);
                }, self::NOTES)
            ]
        );
    }

    /**
     * @Route("/note/{id}", name="note_by_id", requirements={"id"="\d+"})
     */
    public function post($id) {
        return $this->json(
            self::NOTES[array_search($id, array_column(self::NOTES, 'id'))]
        );
    }

    /**
     * @Route("/note/{slug}", name="note_by_slug")
     */
    public function postBySlug($slug) {
        return $this->json(
            self::NOTES[array_search($slug, array_column(self::NOTES, 'slug'))]
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