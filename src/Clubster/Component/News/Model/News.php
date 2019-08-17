<?php

namespace Clubster\Component\News\Model;

use Doctrine\Common\Collections\Collection;

class News implements NewsInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $lead;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $pictureUrl;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var NewsType[]|Collection
     */
    protected $types;
}