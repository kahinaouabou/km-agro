<div style="width: 500px; margin-left : 130px; margin-bottom :60px; margin-top:30px">
    <h1 >{{__('Bon de livraison')}} N° : </h1>
    </div>
    <div style ="width:700px" >
        <table >
            <tr>
                <td style=" font-weight:bold; font-size:22px">{{__('Date')}}: </td>
                <td style=" font-size:20px">
                   </td>
                <td style=" width:350px;text-align:right;
                display: block; position: relative; top:0px; font-weight:bold; font-size:20px"></span>
                </td>
                <td style=" width:200px ; font-size:18px; ">
                </td>
            </tr>
            
        </table>
    
    </div>
    <div style="width: 600px; margin-left : 380px; margin-bottom :20px">
         </div>
  <table width="100%" >
    <tr>
      <?php
       require_once('../vendor/ar-php/ar-php/I18N/Arabic.php');
          $obj = new I18N_Arabic('Glyphs');
          $text = "بذور البطاطا";
         $text = $obj->utf8Glyphs($text);
         
      ?>
        <td><p style="font-size:18px;"><strong >{{__('Product')}} :</strong ><span style="font-family: DejaVu Sans, sans-serif; !important;"><?php echo $text ?></span> (PDT Semence)</p></td>
    
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td><p style="font-size:18px;  width:200px"><strong >{{__('Départ')}} :</strong> Hassi lefhel  W.Ménéa</p></td>
        
        <td ><p style="font-size:18px; width:350px "><strong >{{__('Destinataire')}} :</strong>Entrepôt HAOUCHINE Farid K.E.K W.Boumerdes</p> </td>
    
    </tr>
  </table>
  <br/>


<table width="100%" class='main-table'>
    <thead style="background-color: lightgray;">
      <tr>
      <th>
                    {{__('Nb boxes')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Raw').'  '.__('(Kg)')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Tare').'  '.__('(Kg)')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Net').'  '.__('(Kg)')}} 
      </tr>
    </thead>
    <tbody>
       
            <tr>
                <td align="right" width="100px"></td>
                <td align="right" width="120px"></td>
                <td align="right" width="120px"></td>
                <td align="right" width="160px"></td>
            </tr>
        
     
    </tbody>

 
  </table>
  <table width="100%" >
    <tr>
        <td><p style="font-size:18px"><strong >{{__('Chauffeur')}} :</strong ></p></td>
        
        <td><p style="font-size:18px; margin-left:200px"><strong >{{__('Registration')}} :</strong></p> </td>
    
    </tr>
  </table>