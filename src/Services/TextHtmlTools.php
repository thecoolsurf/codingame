<?php
namespace App\Services;

class TextHtmlTools
{

    /**
     * *************************************************************************
    * html
    */
    public static function msgError($string)
    {
        return '<div id="msg_error">'.$string.'</div>'."\n";
    }
	
    public static function msgValid($string)
    {
        return '<div id="msg_update">'.$string.'</div>'."\n";
    }
	
    public static function msgAjax($head,$message)
    {
        return '<p class="head">'.$head.'</p>|<p class="mess">'.$message.'</p>';
    }
	
    public static function msgAlert($head,$message)
    {
        $mess = NULL;
        $mess .= '<div id="alerte" class="alerte">';
        $mess .= '<p class="head">'.$head.'</p>';
        $mess .= '<p class="mess">'.$message.'</p>';
        $mess .= '<div class="close"><i class="fa fa-close"></i></div>';
        $mess .= '</div>'."\n";
        return $mess;
    }
	
    public static function bonjour()
    {
        return (\date('H')>=18 || \date('H')<=8)?'Bonsoir':'Bonjour';
    }

    /**
     * *************************************************************************
    * string
    */
    public static function displayStringMax($string,$max=0)
    {
        if($max>0):
            $strlimit = \substr($string,0,$max);
        else:
            $strlimit = $string;
        endif;
        return $strlimit;
    }
    
    public static function suppAccents($string)
    {
        $string1 = \htmlentities($string,\ENT_NOQUOTES,'UTF-8');
        $string2 = \preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#','\1',$string1);
        $string3 = \preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string2);
        $string4 = \preg_replace('#&[^;]+;#', '', $string3);
        return $string4;
    }
    
    public static function enCAP($string)
    {
        $string1 = \strtoupper(self::suppAccents($string));
        return $string1;
    }
    
    public static function enBDC($string)
    {
        $string1 = \strtolower(self::suppAccents($string));
        return $string1;
    }
    
    public static function enUCF($string)
    {
        $string1 = \ucfirst(\strtolower(self::suppAccents($string)));
        return $string1;
    }
    
    public static function rewrite($string)
    {
        $string1 = self::suppAccents($string);
        $string2 = \str_replace(' ','-',$string1);
        $string3 = \strtolower($string2);
        return $string3;
    }
    
    public static function replaceText($string)
    {
        $change = [
            'conditions générales'=>'<a href="cgv">conditions générales</a>',
        ];
        foreach($change as $key=>$val):
                $string = \str_replace($key,$val,$string);
        endforeach;
        return $string;
    }

    public static function randomString($max=10)
    {
        $random = NULL;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = \strlen($characters);
        for($i=0; $i<$max; $i++):
            $random .= $characters[\rand(0,$length-1)];
        endfor;
        return $random;
    }
	
	/**
     * *************************************************************************
     * numbers and prices
     */

    public static function numSurOne($val)
    {
        $valSurDix = ($val<10)?\substr($val,1):$val;
        return $valSurDix;
    }

    public static function numSurDix($val)
    {
        $valSurDix = ($val<10)?'0'.$val:$val;
        return $valSurDix;
    }

    public static function numSurCent($val)
    {
        if($val<10):
            $valSurCent = '00'.$val;
        elseif($val<99):
            $valSurCent = '0'.$val;
        else:
            $valSurCent = $val;
        endif;
        return $valSurCent;
    }

    public static function formatPrice($string)
    {
        return \number_format((int)$string,2,'.','');
    }
    
    /**
     * *************************************************************************
     * images
     */
    
    public static function convertSize($octets)
    {
        $result = $octets;
        for($i=0; $i<8 && $result>= 1024; $i++):
            $result = $result/1024;
        endfor;
        if($i>0):
            return \preg_replace('/,00$/','',\number_format($result,2,',','')).' '.\substr('KMGTPEZY',$i-1,1).'o';
        else:
            return $result.' o';
        endif;
    }

}
