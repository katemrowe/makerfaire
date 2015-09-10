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
        $this->SetFont('Arial','B',15);

    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage('P',array(279.4,431.8));
$pdf->SetFont('Helvetica','',12);
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
    $bio =$entry['234'];
  
    $groupname=$entry['109'];
    $groupphoto=$entry['111'];
    $groupbio=$entry['110'];

    $project_name = $entry['151']; 
    $project_photo = $entry['22'];
    $project_short = $entry['16'];
    $project_website = $entry['27'];
    $project_video = $entry['32'];
    $project_title = (string)$entry['151'];

    $project_title  = preg_replace('/\v+|\\\[rn]/','<br/>',$project_title);
    
    // Project ID
    $pdf->SetFont('Arial','',12);
    $pdf->setTextColor(168,170,172);
    $pdf->SetXY(240, 20);      
    $pdf->MultiCell(115, 10, $entry_id,0,'L');  
    
    // Project Title
    $pdf->SetFont('Arial','B',65);
    $pdf->setTextColor(0);
    $pdf->SetXY(12, 75);      
    $pdf->MultiCell(0, 22, $project_title,0,'L');
    
    //print white box to overlay any titles that are too long
    $pdf->SetXY(10, 135); 
    $pdf->Cell(300,20,'',0,2,'L',true);
    
    //field 16 - short description    
    $pdf->SetFont('Helvetica','',30);
    $pdf->SetXY(145, 135);      
    $pdf->MultiCell(125, 10, $project_short,0,'L');  
    
    //field 22 - project photo    
    $pdf->Image($project_photo,12,135,125,0);
          
    //print white box to overlay long descriptions or photos
    $pdf->SetXY(10, 250); 
    $pdf->Cell(300,20,'',0,2,'L',true);
    
    //maker info, use a background of white to overlay any long images or text
    $pdf->setTextColor(0,174,239);
    $pdf->SetFont('Helvetica','B',48);
    
    $pdf->SetXY(10, 270); 
    if (!empty($groupbio)) {                
        $pdf->MultiCell(0, 20, $groupname,0,'L',true); 
        $pdf->setTextColor(0);
        $pdf->SetFont('Helvetica','',24);
        $pdf->MultiCell(0, 10, $groupbio,0,'L',true);  
    }else {            
      $makerList = implode(', ',$makers);      
      $pdf->MultiCell(0, 20, $makerList,0,'L',true);  
      //if size of makers is 1, then display maker bio      
      if(sizeof($makers)==1){
        $pdf->setTextColor(0);
        $pdf->SetFont('Helvetica','',24);
        $pdf->MultiCell(0, 10, $bio,0,'L',true);          
      }
    }
    
}
?>