<?php

namespace App\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;

/**
 * Class Slug.
 */
trait Slug
{
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Creates slug of the string passed.
     *
     * @param $string
     * @param bool $keepArabic
     *
     * @return string
     */
    public function slugify($string, $keepArabic = false)
    {
        if (!$keepArabic) {
            return Str::slug($string, '-');
        } else {
            $text = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
            $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
            $text = trim($text, '-');
            return $text;
        }
    }
}
