<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//set up database 
$root = $_SERVER['DOCUMENT_ROOT'];
require_once( $root.'/wp-config.php' );
require_once( $root.'/wp-includes/wp-db.php' );

//error_log('start of makersigns.php '.date('h:i:s'),0);
// require tFPDF
require_once('fpdf/fpdf.php');

class PDF extends FPDF{
    // Page header
    function Header(){
        // Logo    
        $this->Image('http://makerfaire.com/wp-content/themes/makerfaire/images/maker_sign.png', 0, 0, $this->w, $this->h);
        // Arial bold 15
        $this->SetFont('Benton Sans','B',15);

    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddFont('Benton Sans','B', 'bentonsans-bold-webfont.php');
$pdf->AddFont('Benton Sans','', 'bentonsans-regular-webfont.php');
$pdf->AddPage('P',array(279.4,431.8));
$pdf->SetFont('Benton Sans','',12);
$pdf->SetFillColor(255,255,255);  

//get the entry-id, if one isn't set return an error
if(isset($_GET['eid']) && $_GET['eid']!=''){
    $entryid = $_GET['eid'];    
    createOutput($entryid, $pdf);
    
    
    if(isset($_GET['type']) && $_GET['type']=='download'){
        ob_clean();
        $pdf->Output($entryid.'.pdf', 'D');        
    }elseif(isset($_GET['type'])&&$_GET['type']=='save'){
        $filename = TEMPLATEPATH.'/signs/NY15/'.$entryid.'.pdf';
        $dirname = dirname($filename);
        if (!is_dir($dirname))
        {
            mkdir($dirname, 0755, true);
        }
        $pdf->Output($filename, 'F');                 
        echo $entryid;
    }else{
        ob_clean();
        $pdf->Output($entryid.'.pdf', 'I');
    }
    
    //error_log('after writing pdf '.date('h:i:s'),0);
}else{
    echo 'No Entry ID submitted';
}


function createOutput($entry_id,$pdf){
    $entry = GFAPI::get_entry( $entry_id );
    $makers = array();
    if (strlen($entry['160.3']) > 0) $makers[] = $entry['160.3'] . ' ' .$entry['160.6'];
    if (strlen($entry['158.3']) > 0) $makers[] = $entry['158.3'] . ' ' .$entry['158.6'];
    if (strlen($entry['155.3']) > 0) $makers[] = $entry['155.3'] . ' ' .$entry['155.6'];
    if (strlen($entry['156.3']) > 0) $makers[] = $entry['156.3'] . ' ' .$entry['156.6'];
    if (strlen($entry['157.3']) > 0) $makers[] = $entry['157.3'] . ' ' .$entry['157.6'];
    if (strlen($entry['159.3']) > 0) $makers[] = $entry['159.3'] . ' ' .$entry['159.6'];
    if (strlen($entry['154.3']) > 0) $makers[] = $entry['154.3'] . ' ' .$entry['154.6'];

    //maker 1 bio
    $bio =filterText($entry['234']);
  
    $groupname=$entry['109'];
    $groupphoto=$entry['111'];
    $groupbio=filterText($entry['110']);

    $project_name = filterText($entry['151']); 
    $project_photo = $entry['22'];
    $project_short = filterText($entry['16']);
    $project_website = $entry['27'];
    $project_video = $entry['32'];
    $project_title = filterText((string)$entry['151']);

    $project_title  = preg_replace('/\v+|\\\[rn]/','<br/>',$project_title);
    
    // Project ID
    $pdf->SetFont('Benton Sans','',12);
    $pdf->setTextColor(168,170,172);
    $pdf->SetXY(240, 20);      
    $pdf->MultiCell(115, 10, $entry_id,0,'L');  
    
    // Project Title     
    $pdf->setTextColor(0);
    $pdf->SetXY(12, 75);   
        
    //auto adjust the font so the text will fit
    $x = 65;    // set the starting font size
    $pdf->SetFont( 'Benton Sans','B',65);    
    
    /* Cycle thru decreasing the font size until it's width is lower than the max width */
    while( $pdf->GetStringWidth( utf8_decode( $project_title)) > 400 ){
        $x--;   // Decrease the variable which holds the font size
        $pdf->SetFont( 'Benton Sans','B',$x);
    }
    $lineHeight = $x*0.2645833333333*1.3;
    
    
    /* Output the title at the required font size */
    $pdf->MultiCell(0, $lineHeight, $project_title,0,'L');
    
    //field 16 - short description    
    //auto adjust the font so the text will fit
    $pdf->SetXY(145, 135);   
    
    
    //auto adjust the font so the text will fit
    $sx = 30;    // set the starting font size
    $pdf->SetFont( 'Benton Sans','',$sx); 
    
    // Cycle thru decreasing the font size until it's width is lower than the max width 
    while( $pdf->GetStringWidth( utf8_decode( $project_short)) > 1300 ){        
        $sx--;   // Decrease the variable which holds the font size 
        $pdf->SetFont( 'Benton Sans','',$sx);            
    }   
    
    $lineHeight = $sx*0.2645833333333*1.3;
       
    $pdf->MultiCell(125, $lineHeight, $project_short,0,'L');  
     
    //field 22 - project photo   
    $photo_extension  = exif_imagetype($project_photo);
    if ($photo_extension) {
    	//DEBUG:
    	$project_photo = legacy_get_fit_remote_image_url($project_photo,450,450,0);
    	$pdf->Image($project_photo,12,135,null,null,image_type_to_extension($photo_extension,false));          
    }
    //print white box to overlay long descriptions or photos
    /*$pdf->SetXY(10, 255); 
    $pdf->Cell(300,80,'',0,2,'L',true);*/

    
    //maker info, use a background of white to overlay any long images or text
    $pdf->setTextColor(0,174,239);
    $pdf->SetFont('Benton Sans','B',48);
    
    $pdf->SetXY(10, 270); 
    if (!empty($groupbio)) {     
        //auto adjust the font so the text will fit
        $sx = 48;    // set the starting font size

        // Cycle thru decreasing the font size until it's width is lower than the max width 
        while( $pdf->GetStringWidth( utf8_decode( $groupname)) > 240 ){        
            $sx--;   // Decrease the variable which holds the font size 
            $pdf->SetFont( 'Benton Sans','B',$sx);            
        }   

        $lineHeight = $sx*0.2645833333333*1.3;
        
        $pdf->MultiCell(0, $lineHeight, $groupname,0,'L',true); 
       
        $pdf->setTextColor(0);
        $pdf->SetFont('Benton Sans','',24);        
        
        //auto adjust the font so the text will fit
        $x = 24;    // set the starting font size

        /* Cycle thru decreasing the font size until it's width is lower than the max width */
        while( $pdf->GetStringWidth( $groupbio) > 1200 ){
            $x--;   // Decrease the variable which holds the font size
            $pdf->SetFont( 'Benton Sans','',$x);
        }
        $lineHeight = $x*0.2645833333333*1.3;
        $pdf->MultiCell(0, $lineHeight, $groupbio,0,'L',true);  
    }else {            
        $makerList = implode(', ',$makers);              
        $pdf->SetFont('Benton Sans','B',48);
        
        //auto adjust the font so the text will fit
        $x = 48;    // set the starting font size

        /* Cycle thru decreasing the font size until it's width is lower than the max width */
        while( $pdf->GetStringWidth( utf8_decode( $makerList)) > 900 ){
            $x--;   // Decrease the variable which holds the font size
            $pdf->SetFont( 'Benton Sans','',$x);
        }
        $lineHeight = $x*0.2645833333333*1.3;
        $pdf->MultiCell(0, $lineHeight, $makerList,0,'L',true);
      //if size of makers is 1, then display maker bio      
      if(sizeof($makers)==1){
        $pdf->setTextColor(0);
        $pdf->SetFont('Benton Sans','',24);
        
        //auto adjust the font so the text will fit
        $x = 24;    // set the starting font size
        /* Cycle thru decreasing the font size until it's width is lower than the max width */
        while( $pdf->GetStringWidth( $bio) > 900 ){
            $x--;   // Decrease the variable which holds the font size
            $pdf->SetFont( 'Benton Sans','',$x);
        }
        
        $lineHeight = $x*0.2645833333333*1.37;
        $pdf->MultiCell(0, $lineHeight, $bio,0,'L',true);          
      }
    }
    
}

function filterText($text)
{

	//UTF-8 filter
	$conv = array(
			"\xC2\xA0" => '&nbsp;',
			"\xC2\xA1" => '&iexcl;',
			"\xC2\xA2" => '&cent;',
			"\xC2\xA3" => '&pound;',
			"\xC2\xA4" => '&curren;',
			"\xC2\xA5" => '&yen;',
			"\xC2\xA6" => '&brvbar;',
			"\xC2\xA7" => '&sect;',
			"\xC2\xA8" => '&uml;',
			"\xC2\xA9" => '&copy;',
			"\xC2\xAA" => '&ordf;',
			"\xC2\xAB" => '&laquo;',
			"\xC2\xAC" => '&not;',
			"\xC2\xAD" => '&shy;',
			"\xC2\xAE" => '&reg;',
			"\xC2\xAF" => '&macr;',
			"\xC2\xB0" => '&deg;',
			"\xC2\xB1" => '&plusmn;',
			"\xC2\xB2" => '&sup2;',
			"\xC2\xB3" => '&sup3;',
			"\xC2\xB4" => '&acute;',
			"\xC2\xB5" => '&micro;',
			"\xC2\xB6" => '&para;',
			"\xC2\xB7" => '&middot;',
			"\xC2\xB8" => '&cedil;',
			"\xC2\xB9" => '&sup1;',
			"\xC2\xBA" => '&ordm;',
			"\xC2\xBB" => '&raquo;',
			"\xC2\xBC" => '&frac14;',
			"\xC2\xBD" => '&frac12;',
			"\xC2\xBE" => '&frac34;',
			"\xC2\xBF" => '&iquest;',
			"\xC3\x80" => '&Agrave;',
			"\xC3\x81" => '&Aacute;',
			"\xC3\x82" => '&Acirc;',
			"\xC3\x83" => '&Atilde;',
			"\xC3\x84" => '&Auml;',
			"\xC3\x85" => '&Aring;',
			"\xC3\x86" => '&AElig;',
			"\xC3\x87" => '&Ccedil;',
			"\xC3\x88" => '&Egrave;',
			"\xC3\x89" => '&Eacute;',
			"\xC3\x8A" => '&Ecirc;',
			"\xC3\x8B" => '&Euml;',
			"\xC3\x8C" => '&Igrave;',
			"\xC3\x8D" => '&Iacute;',
			"\xC3\x8E" => '&Icirc;',
			"\xC3\x8F" => '&Iuml;',
			"\xC3\x90" => '&ETH;',
			"\xC3\x91" => '&Ntilde;',
			"\xC3\x92" => '&Ograve;',
			"\xC3\x93" => '&Oacute;',
			"\xC3\x94" => '&Ocirc;',
			"\xC3\x95" => '&Otilde;',
			"\xC3\x96" => '&Ouml;',
			"\xC3\x97" => '&times;',
			"\xC3\x98" => '&Oslash;',
			"\xC3\x99" => '&Ugrave;',
			"\xC3\x9A" => '&Uacute;',
			"\xC3\x9B" => '&Ucirc;',
			"\xC3\x9C" => '&Uuml;',
			"\xC3\x9D" => '&Yacute;',
			"\xC3\x9E" => '&THORN;',
			"\xC3\x9F" => '&szlig;',
			"\xC3\xA0" => '&agrave;',
			"\xC3\xA1" => '&aacute;',
			"\xC3\xA2" => '&acirc;',
			"\xC3\xA3" => '&atilde;',
			"\xC3\xA4" => '&auml;',
			"\xC3\xA5" => '&aring;',
			"\xC3\xA6" => '&aelig;',
			"\xC3\xA7" => '&ccedil;',
			"\xC3\xA8" => '&egrave;',
			"\xC3\xA9" => '&eacute;',
			"\xC3\xAA" => '&ecirc;',
			"\xC3\xAB" => '&euml;',
			"\xC3\xAC" => '&igrave;',
			"\xC3\xAD" => '&iacute;',
			"\xC3\xAE" => '&icirc;',
			"\xC3\xAF" => '&iuml;',
			"\xC3\xB0" => '&eth;',
			"\xC3\xB1" => '&ntilde;',
			"\xC3\xB2" => '&ograve;',
			"\xC3\xB3" => '&oacute;',
			"\xC3\xB4" => '&ocirc;',
			"\xC3\xB5" => '&otilde;',
			"\xC3\xB6" => '&ouml;',
			"\xC3\xB7" => '&divide;',
			"\xC3\xB8" => '&oslash;',
			"\xC3\xB9" => '&ugrave;',
			"\xC3\xBA" => '&uacute;',
			"\xC3\xBB" => '&ucirc;',
			"\xC3\xBC" => '&uuml;',
			"\xC3\xBD" => '&yacute;',
			"\xC3\xBE" => '&thorn;',
			"\xC3\xBF" => '&yuml;',
			// Latin Extended-A
	"\xC5\x92" => '&OElig;',
	"\xC5\x93" => '&oelig;',
	"\xC5\xA0" => '&Scaron;',
	"\xC5\xA1" => '&scaron;',
	"\xC5\xB8" => '&Yuml;',
	// Spacing Modifier Letters
	"\xCB\x86" => '&circ;',
	"\xCB\x9C" => '&tilde;',
	// General Punctuation
	"\xE2\x80\x82" => '&ensp;',
	"\xE2\x80\x83" => '&emsp;',
	"\xE2\x80\x89" => '&thinsp;',
	"\xE2\x80\x8C" => '&zwnj;',
	"\xE2\x80\x8D" => '&zwj;',
	"\xE2\x80\x8E" => '&lrm;',
	"\xE2\x80\x8F" => '&rlm;',
	"\xE2\x80\x93" => '&ndash;',
	"\xE2\x80\x94" => '&mdash;',
	"\xE2\x80\x98" => '&lsquo;',
	"\xE2\x80\x99" => "'",
	"\xE2\x80\x9A" => '&sbquo;',
	"\xE2\x80\x9C" => '&ldquo;',
	"\xE2\x80\x9D" => '&rdquo;',
	"\xE2\x80\x9E" => '&bdquo;',
	"\xE2\x80\xA0" => '&dagger;',
	"\xE2\x80\xA1" => '&Dagger;',
	"\xE2\x80\xB0" => '&permil;',
	"\xE2\x80\xB9" => '&lsaquo;',
	"\xE2\x80\xBA" => '&rsaquo;',
	"\xE2\x82\xAC" => '&euro;',
	// Latin Extended-B
	"\xC6\x92" => '&fnof;',
	// Greek
	"\xCE\x91" => '&Alpha;',
	"\xCE\x92" => '&Beta;',
	"\xCE\x93" => '&Gamma;',
	"\xCE\x94" => '&Delta;',
	"\xCE\x95" => '&Epsilon;',
	"\xCE\x96" => '&Zeta;',
	"\xCE\x97" => '&Eta;',
	"\xCE\x98" => '&Theta;',
	"\xCE\x99" => '&Iota;',
	"\xCE\x9A" => '&Kappa;',
	"\xCE\x9B" => '&Lambda;',
	"\xCE\x9C" => '&Mu;',
	"\xCE\x9D" => '&Nu;',
	"\xCE\x9E" => '&Xi;',
	"\xCE\x9F" => '&Omicron;',
	"\xCE\xA0" => '&Pi;',
	"\xCE\xA1" => '&Rho;',
	"\xCE\xA3" => '&Sigma;',
	"\xCE\xA4" => '&Tau;',
	"\xCE\xA5" => '&Upsilon;',
	"\xCE\xA6" => '&Phi;',
	"\xCE\xA7" => '&Chi;',
	"\xCE\xA8" => '&Psi;',
	"\xCE\xA9" => '&Omega;',
	"\xCE\xB1" => '&alpha;',
	"\xCE\xB2" => '&beta;',
	"\xCE\xB3" => '&gamma;',
	"\xCE\xB4" => '&delta;',
	"\xCE\xB5" => '&epsilon;',
	"\xCE\xB6" => '&zeta;',
	"\xCE\xB7" => '&eta;',
	"\xCE\xB8" => '&theta;',
	"\xCE\xB9" => '&iota;',
	"\xCE\xBA" => '&kappa;',
	"\xCE\xBB" => '&lambda;',
	"\xCE\xBC" => '&mu;',
	"\xCE\xBD" => '&nu;',
	"\xCE\xBE" => '&xi;',
	"\xCE\xBF" => '&omicron;',
	"\xCF\x80" => '&pi;',
	"\xCF\x81" => '&rho;',
	"\xCF\x82" => '&sigmaf;',
	"\xCF\x83" => '&sigma;',
	"\xCF\x84" => '&tau;',
	"\xCF\x85" => '&upsilon;',
	"\xCF\x86" => '&phi;',
	"\xCF\x87" => '&chi;',
	"\xCF\x88" => '&psi;',
	"\xCF\x89" => '&omega;',
	"\xCF\x91" => '&thetasym;',
	"\xCF\x92" => '&upsih;',
	"\xCF\x96" => '&piv;',
	// General Punctuation
	"\xE2\x80\xA2" => '&bull;',
	"\xE2\x80\xA6" => '&hellip;',
	"\xE2\x80\xB2" => '&prime;',
	"\xE2\x80\xB3" => '&Prime;',
	"\xE2\x80\xBE" => '&oline;',
	"\xE2\x81\x84" => '&frasl;',
	// Letterlike Symbols
	"\xE2\x84\x98" => '&weierp;',
	"\xE2\x84\x91" => '&image;',
	"\xE2\x84\x9C" => '&real;',
	"\xE2\x84\xA2" => '&trade;',
	"\xE2\x84\xB5" => '&alefsym;',
	// Arrows
	"\xE2\x86\x90" => '&larr;',

	"\xE2\x86\x91" => '&uarr;',
	"\xE2\x86\x92" => '&rarr;',
	"\xE2\x86\x93" => '&darr;',
	"\xE2\x86\x94" => '&harr;',
	"\xE2\x86\xB5" => '&crarr;',
	"\xE2\x87\x90" => '&lArr;',
	"\xE2\x87\x91" => '&uArr;',
	"\xE2\x87\x92" => '&rArr;',
	"\xE2\x87\x93" => '&dArr;',
	"\xE2\x87\x94" => '&hArr;',
	// Mathematical Operators
	"\xE2\x88\x80" => '&forall;',
	"\xE2\x88\x82" => '&part;',
	"\xE2\x88\x83" => '&exist;',
	"\xE2\x88\x85" => '&empty;',
	"\xE2\x88\x87" => '&nabla;',
	"\xE2\x88\x88" => '&isin;',
	"\xE2\x88\x89" => '&notin;',
	"\xE2\x88\x8B" => '&ni;',
	"\xE2\x88\x8F" => '&prod;',
	"\xE2\x88\x91" => '&sum;',
	"\xE2\x88\x92" => '&minus;',
	"\xE2\x88\x97" => '&lowast;',
	"\xE2\x88\x9A" => '&radic;',
	"\xE2\x88\x9D" => '&prop;',
	"\xE2\x88\x9E" => '&infin;',
	"\xE2\x88\xA0" => '&ang;',
	"\xE2\x88\xA7" => '&and;',
	"\xE2\x88\xA8" => '&or;',
	"\xE2\x88\xA9" => '&cap;',
	"\xE2\x88\xAA" => '&cup;',
	"\xE2\x88\xAB" => '&int;',
	"\xE2\x88\xB4" => '&there4;',
	"\xE2\x88\xBC" => '&sim;',
	"\xE2\x89\x85" => '&cong;',
	"\xE2\x89\x88" => '&asymp;',
	"\xE2\x89\xA0" => '&ne;',
	"\xE2\x89\xA1" => '&equiv;',
	"\xE2\x89\xA4" => '&le;',
	"\xE2\x89\xA5" => '&ge;',
	"\xE2\x8A\x82" => '&sub;',
	"\xE2\x8A\x83" => '&sup;',
	"\xE2\x8A\x84" => '&nsub;',
	"\xE2\x8A\x86" => '&sube;',
	"\xE2\x8A\x87" => '&supe;',
	"\xE2\x8A\x95" => '&oplus;',
	"\xE2\x8A\x97" => '&otimes;',
	"\xE2\x8A\xA5" => '&perp;',
	"\xE2\x8B\x85" => '&sdot;',
	// Miscellaneous Technical
	"\xE2\x8C\x88" => '&lceil;',
	"\xE2\x8C\x89" => '&rceil;',
	"\xE2\x8C\x8A" => '&lfloor;',
	"\xE2\x8C\x8B" => '&rfloor;',
	"\xE2\x8C\xA9" => '&lang;',
	"\xE2\x8C\xAA" => '&rang;',
	// Geometric Shapes
	"\xE2\x97\x8A" => '&loz;',
	// Miscellaneous Symbols
	"\xE2\x99\xA0" => '&spades;',
	"\xE2\x99\xA3" => '&clubs;',
	"\xE2\x99\xA5" => '&hearts;',
	"\xE2\x99\xA6" => '&diams;'
			);

	$string = strtr($text, $conv);

	//now translate any unicode stuff...
	$conv = array(
			chr(128) => "&euro;",
			chr(130) => "&sbquo;",
			chr(131) => "&fnof;",
			chr(132) => "&bdquo;",
			chr(133) => "&hellip;",
			chr(134) => "&dagger;",
			chr(135) => "&Dagger;",
			chr(136) => "&circ;",
			chr(137) => "&permil;",
			chr(138) => "&Scaron;",
			chr(139) => "&lsaquo;",
			chr(140) => "&OElig;",
			chr(145) => "&lsquo;",
			chr(146) => "'",
			chr(147) => "&ldquo;",
			chr(148) => "&rdquo;",
			chr(149) => "&bull;",
			chr(150) => "&ndash;",
			chr(151) => "&mdash;",
			chr(152) => "&tilde;",
			chr(153) => "&trade;",
			chr(154) => "&scaron;",
			chr(155) => "&rsaquo;",
			chr(156) => "&oelig;",
			chr(159) => "&yuml;",
			chr(160) => "&nbsp;",
			chr(161) => "&iexcl;",
			chr(162) => "&cent;",
			chr(163) => "&pound;",
			chr(164) => "&curren;",
			chr(165) => "&yen;",
			chr(166) => "&brvbar;",
			chr(167) => "&sect;",
			chr(168) => "&uml;",
			chr(169) => "&copy;",
			chr(170) => "&ordf;",
			chr(171) => "&laquo;",
			chr(172) => "&not;",
			chr(173) => "&shy;",
			chr(174) => "&reg;",
			chr(175) => "&macr;",
			chr(176) => "&deg;",
			chr(177) => "&plusmn;",
			chr(178) => "&sup2;",
			chr(179) => "&sup3;",
			chr(180) => "&acute;",
			chr(181) => "&micro;",
			chr(182) => "&para;",
			chr(183) => "&middot;",
			chr(184) => "&cedil;",
			chr(185) => "&sup1;",
			chr(186) => "&ordm;",
			chr(187) => "&raquo;",
			chr(188) => "&frac14;",
			chr(189) => "&frac12;",
			chr(190) => "&frac34;",
			chr(191) => "&iquest;",
			chr(192) => "&Agrave;",
			chr(193) => "&Aacute;",
			chr(194) => "&Acirc;",
			chr(195) => "&Atilde;",
			chr(196) => "&Auml;",
			chr(197) => "&Aring;",
			chr(198) => "&AElig;",
			chr(199) => "&Ccedil;",
			chr(200) => "&Egrave;",
			chr(201) => "&Eacute;",
			chr(202) => "&Ecirc;",
			chr(203) => "&Euml;",
			chr(204) => "&Igrave;",
			chr(205) => "&Iacute;",
			chr(206) => "&Icirc;",
			chr(207) => "&Iuml;",
			chr(208) => "&ETH;",
			chr(209) => "&Ntilde;",
			chr(210) => "&Ograve;",
			chr(211) => "&Oacute;",
			chr(212) => "&Ocirc;",
			chr(213) => "&Otilde;",
			chr(214) => "&Ouml;",
			chr(215) => "&times;",
			chr(216) => "&Oslash;",
			chr(217) => "&Ugrave;",
			chr(218) => "&Uacute;",
			chr(219) => "&Ucirc;",
			chr(220) => "&Uuml;",
			chr(221) => "&Yacute;",
			chr(222) => "&THORN;",
			chr(223) => "&szlig;",
			chr(224) => "&agrave;",
			chr(225) => "&aacute;",
			chr(226) => "&acirc;",
			chr(227) => "&atilde;",
			chr(228) => "&auml;",
			chr(229) => "&aring;",
			chr(230) => "&aelig;",
			chr(231) => "&ccedil;",
			chr(232) => "&egrave;",
			chr(233) => "&eacute;",
			chr(234) => "&ecirc;",
			chr(235) => "&euml;",
			chr(236) => "&igrave;",
			chr(237) => "&iacute;",
			chr(238) => "&icirc;",
			chr(239) => "&iuml;",
			chr(240) => "&eth;",
			chr(241) => "&ntilde;",
			chr(242) => "&ograve;",
			chr(243) => "&oacute;",
			chr(244) => "&ocirc;",
			chr(245) => "&otilde;",
			chr(246) => "&ouml;",
			chr(247) => "&divide;",
			chr(248) => "&oslash;",
			chr(249) => "&ugrave;",
			chr(250) => "&uacute;",
			chr(251) => "&ucirc;",
			chr(252) => "&uuml;",
			chr(253) => "&yacute;",
			chr(254) => "&thorn;",
			chr(255) => "&yuml;");


	return strtr($string, $conv);


}

?>