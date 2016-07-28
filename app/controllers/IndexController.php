<?php

/**
 * 
 */

namespace SoftnCMS\controllers;

/**
 * Description of SoftN
 *
 * @author Nicolás Marulanda P.
 */
class IndexController {

    public function __construct() {
        /*
         * --- count
         * post
         * page
         * comment
         * category
         * user
         * --- ultimas actulizaciones github
         * --- ultimos post
         * -- comentarios recientes
         */
    }

    public function index() {
        return ['data' => $this->dataIndex()];
    }

    private function dataIndex() {
        $posts = new \SoftnCMS\models\Posts();

        return [
            'github' => $this->lastUpdateGitHub(),
            'lastPosts' => $posts->lastPosts(5),
            'lastComments' => [],
            'count' => [
                'post' => $posts->count(),
                'page' => 0,
                'category' => 0,
                'comment' => 0,
                'user' => 0,
            ],
        ];
    }

    private function lastUpdateGitHub() {
        $lengTitle = 20;
        $github = \simplexml_load_file('https://github.com/nmarulo/softn-cms/commits/master.atom');
        $github = \get_object_vars($github);
        $leng = count($github['entry']);
        $forEnd = $leng > 5 ? 5 : $leng;
        $dataGitHub = [
            'lastUpdate' => $github['updated'],
            'entry' => [],
        ];

        /*
         * Indices de $elements "id", "link"=>"@attributes"=>"href", "title",
         * "updated", "author"=>"name", "author"=>"uri", "content"
         */
        for ($i = 0; $i < $forEnd; ++$i) {
            $element = \get_object_vars($github['entry'][$i]);
            $title = $element['title'];
            $element['link'] = \get_object_vars($element['link']);
            $element['author'] = \get_object_vars($element['author']);

            if (isset($title{$lengTitle})) {
                $title = \substr($title, 0, $lengTitle) . ' [...]';
            }

            $dataGitHub['entry'][] = [
                'authorName' => $element['author']['name'],
                'authorUri' => $element['author']['uri'],
                'linkHref' => $element['link']['@attributes']['href'],
                'title' => $title,
            ];
        }
        return $dataGitHub;
    }

}
