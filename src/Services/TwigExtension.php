<?php

namespace App\Services;


class TwigExtension
{

    public $twig;

    /*
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    */
    
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('file_exists','file_exists'),
            new Twig_SimpleFunction('displayStringMax',[$this,'displayStringMax']),
            new Twig_SimpleFunction('slugify',[$this,'slugify']),
            new Twig_SimpleFunction('sortByFields',[$this,'sortByFields']),
        );
    }

    public function getName()
    {
        return 'app_file';
    }

    /* ********************************************************************** */
    
    public function sortByField($content, $sort_by, $direction = 'asc')
    {
        if (\is_a($content, 'Doctrine\ORM\PersistentCollection')) {
            $content = $content->toArray();
        }
        if (!\is_array($content)) {
            throw new \InvalidArgumentException('Variable passed to the sortByField filter is not an array');
        } elseif (\count($content) < 1) {
            return $content;
        } else {
            \usort($content, function ($a, $b) use ($sort_by, $direction) {
                $flip = ($direction === 'desc') ? -1 : 1;
                if (\is_array($a)) {
                    $a_sort_value = $a[$sort_by];
                } else if (method_exists($a, 'get' . ucfirst($sort_by))) {
                    $a_sort_value = $a->{'get' . ucfirst($sort_by)}();
                } else {
                    $a_sort_value = $a->$sort_by;
                }
                if (\is_array($b)) {
                    $b_sort_value = $b[$sort_by];
                } else if (\method_exists($b, 'get' . \ucfirst($sort_by))) {
                    $b_sort_value = $b->{'get' . \ucfirst($sort_by)}();
                } else {
                    $b_sort_value = $b->$sort_by;
                }
                if ($a_sort_value == $b_sort_value) {
                    return 0;
                } else if ($a_sort_value > $b_sort_value) {
                    return (1 * $flip);
                } else {
                    return (-1 * $flip);
                }
            });
        }
        return $content;
    }

    public function deleteAccents($text)
    {
        $string1 = \htmlentities($text,ENT_NOQUOTES,'UTF-8');
        $string2 = \preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#','\1',$string1);
        $string3 = \preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string2);
        $string4 = \preg_replace('#&[^;]+;#', '', $string3);
        return $string4;
    }

    public function slugify($text)
    {
        //in:     Physique: - culture_générale.
        //out:    physique-culture-generale
        $pattern = array('/[_]+/','/[^a-zA-Z0-9 -]/','/[ -]+/','/[ .]/','/[ :]/','/^-|-$/');
        $replacement = array('-','','-','','','');
        $string = $this->deleteAccents($text);
        $preg_replace = \preg_replace($pattern,$replacement,$string);
        $slugify = \strtolower($preg_replace);
        return $slugify;
    }

    public function displayStringMax($string,$max)
    {
        $TextHtmlTools = TextHtmlTools::displayStringMax($string,$max);
        return $TextHtmlTools;
    }
    
    public function randomPass($max)
    {
        $charts = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $randompass = '';
        for($i=0; $i<$max; $i++):
            $randompass .= \substr($charts, \rand() % (\strlen($charts)), 1);
        endfor;
        return $randompass;
    }
    
    public function numberToStringList($val)
    {
        $string = $val<10 ? '0'.$val : $val;
        return $string;
    }

}
