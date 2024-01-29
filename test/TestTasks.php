<?php

declare (strict_types=1);
require_once __DIR__ . '/../src/tasks.php';

/**
 * Funktion för att testa alla aktiviteter
 * @return string html-sträng med resultatet av alla tester
 */
function allaTaskTester(): string {
// Kom ihåg att lägga till alla testfunktioner
    $retur = "<h1>Testar alla uppgiftsfunktioner</h1>";
    $retur .= test_HamtaEnUppgift();
    $retur .= test_HamtaUppgifterSida();
    $retur .= test_RaderaUppgift();
    $retur .= test_SparaUppgift();
    $retur .= test_UppdateraUppgifter();
    return $retur;
}

/**
 * Tester för funktionen hämta uppgifter för ett angivet sidnummer
 * @return string html-sträng med alla resultat för testerna 
 */
function test_HamtaUppgifterSida(): string {
    $retur = "<h2>test_HamtaUppgifterSida</h2>";
    try{
    // Misslyckas med att hämta sida -1
        $svar=hamtaSida("-1");
        if($svar->getStatus()===400){
            $retur.= "<p class='ok'>Misslyckades med att hämta sida -1 som förväntat</p>";
        } else {
            $retur.= "<p class='error'>Misslyckades test att hämta sida -1<br>"
                . $svar->getStatus() . "returnerades istället för förväntat 400</p>";
        }

    // Misslyckas med att hämta sida 0
    $svar=hamtaSida("0");
    if($svar->getStatus()===400){
        $retur.= "<p class='ok'>Misslyckades med att hämta sida 0 som förväntat</p>";
    } else {
        $retur.= "<p class='error'>Misslyckades test att hämta sida 0<br>"
            . $svar->getStatus() . "returnerades istället för förväntat 400</p>";
    }


    // Misslyckas med att hämta sida 7
    $svar=hamtaSida("sju");
    if($svar->getStatus()===400){
        $retur.= "<p class='ok'>Misslyckades med att hämta sida sju som förväntat</p>";
    } else {
        $retur.= "<p class='error'>Misslyckades test att hämta sida sju<br>"
            . $svar->getStatus() . "returnerades istället för förväntat 400</p>";
    }


    // Lyckas med att hämta sida 1
    $svar=hamtaSida("1",2);
    if($svar->getStatus()===200){
        $retur.= "<p class='ok'>Lyckades med att hämta sida 1</p>";
        $sista=$svar->getContent()->pages;
    } else {
        $retur.= "<p class='error'>Misslyckades test att hämta sida 1<br>"
            . $svar->getStatus() . "returnerades istället för förväntat 200</p>";
    }


    // Misslyckas med att hämta sida > antal sidor
    if(isset($sista)){
        $sista++;
        $svar= hamtaSida("$sista", 2);
        if($svar->getStatus()===400){
            $retur.= "<p class='ok'>Misslyckades med att hämta sida > antal sidor, som förväntat</p>";
        }else{
            $retur.= "<p class='error'>Misslyckades test att hämta sida > antal sidor<br>"
                . $svar->getStatus() . "returnerades istället för förväntat 400</p>";
        }
    }


    
        
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen hämta uppgifter mellan angivna datum
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaAllaUppgifterDatum(): string {
    $retur = "<h2>test_HamtaAllaUppgifterDatum</h2>";
    try {
        // Misslyckas med från=igår till=2024-01-01
        $svar= hamtaDatum("igår", "2024-01-01");
        if($svar->getStatus()===400){
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan <i>igår</i> och 2024-01-01 som förväntat</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades test med att hämta poster mellan <i>igår</i> och 2024-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        // Misslyckas med från=2024-01-01 till=imorgon
        $svar= hamtaDatum("2024-01-01", "imorgon");
        if($svar->getStatus()===400){
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och <i>imorgon</i> som förväntat</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades test med att hämta poster mellan 2024-01-01 och <i>imorgon</i><br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }
        // Misslyckas med från=2024-12-37 till=2024-01-01
        $svar= hamtaDatum("2024-12-37", "2024-01-01");
        if($svar->getStatus()===400){
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-12-37 och 2024-01-01 som förväntat</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades test med att hämta poster mellan 2024-12-37 och 2024-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }
        // Misslyckas med från=2024-01-01 till=2024-01-37
        $svar= hamtaDatum("2024-01-01", "2024-01-37");
        if($svar->getStatus()===400){
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2024-01-37 som förväntat</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades test med att hämta poster mellan 2024-01-01 och 2024-01-37<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }
        // Misslyckas med från=2024-01-01 till=2023-01-01
        $svar= hamtaDatum("2024-01-01", "2023-01-01");
        if($svar->getStatus()===400){
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2023-01-01 som förväntat</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades test med att hämta poster mellan 2024-01-01 och 2023-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }
        // Lyckas med korrekta datum
        // Leta upp en månad med poster
        $db=connectDb();
        $stmt=$db->query("SELECT YEAR(datum), MONTH(datum), COUNT(*) AS antal "
        . "FROM uppgifter "
        . "GROUP BY YEAR(datum), MONTH(datum) "
        . "ORDER BY antal DESC "
        . "LIMIT 0,1");
        $row=$stmt->fetch();
        $ar=$row[0];
        $manad=substr("0$row[1]", -2);
        $antal=$row[2];

        // Hämta alla poster från den funna månaden
        $svar= hamtaDatum("$ar-$manad-01", date("Y-m-d", strtotime("Last day of $ar-$manad")));
        if($svar->getStatus()===200 && count($svar->getContent()->tasks)===$antal){
        $retur .= "<p class='ok'>Lyckades hämta $antal poster för månad $ar-$manad</p>";
        }else{
            $retur .= "<p class='error'>Misslyckades med att hämta poster för $ar-$manad<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        
        }
       
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test av funktionen hämta enskild uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaEnUppgift(): string {
    $retur = "<h2>test_HamtaEnUppgift</h2>";

    try {
        // Misslyckas med att hämta id=0
        $svar= hamtaEnskildUppgift("0");
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=0, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att hämta uppgift med id=0<br>"
            .$svar->getStatus() . " returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med att hämta id=sju
        $svar= hamtaEnskildUppgift("sju");
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=sju, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att hämta uppgift med id=sju<br>"
            .$svar->getStatus() . " returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med att hämta id=3.14
        $svar= hamtaEnskildUppgift("3.14");
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=3.14, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att hämta uppgift med id=3.14<br>"
            .$svar->getStatus() . " returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Lyckas hämta id som finns

        // Koppla databas + skapa transaktion
        $db=connectDb();
        $db->beginTransaction();
        //Förbered data
        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;
        $postdata=["date"=>date('Y-m-d'),
            "time"=>"01:00",
            "description"=>"Testpost",
            "activityId"=>"$aktivitetId"];

        // Skapa post
       $svar= sparaNyUppgift($postdata);
       $taskId=$svar->getContent()->id;

        // Hämta nyss skapad post
        $svar=hamtaEnskildUppgift("$taskId");
        if($svar->getStatus()===200){
            $retur .="<p class='ok'>Lyckades hämta en uppgift</p>";
        } else{
            $retur .="<p class='error'>Misslyckades hämta nyskapad uppgift<br>"
            .$svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
       
        // Misslyckas med att hämta id som inte finns
        $taskId++;
        $svar=hamtaEnskildUppgift("$taskId");
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades hämta en uppgift som inte finns</p>";
        } else{
            $retur .="<p class='error'>Misslyckades hämta uppgift som inte finns<br>"
            .$svar->getStatus() . " returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    } finally {
        if($db){
            $db->rollBack();
        }
    }


    return $retur;
}

/**
 * Test för funktionen spara uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_SparaUppgift(): string {
    $retur = "<h2>test_SparaUppgift</h2>";

    try {
        $db=connectDb();
        // Skapa en transaktion så att vi slipper skräp i databasen
        $db->beginTransaction();

        // Misslyckas med att spara pga saknad aktivitetid
        $postdata=['time'=>'01:00',
                'date'=>'2023-12-31',
                'description'=>'Detta är en testpost'];

                $svar=sparaNyUppgift($postdata);
                if($svar->getStatus()===400){
                  $retur .="<p class='ok'>Misslyckades med att spara post utan aktivitetid, som förväntat</p>";
                } else {
                    $retur .="<p class='error'>Misslyckades med att spara post utan aktivitetid<br>"
                    . $svar->getStatus(). "returnerades istället för förväntat 400<br>"
                    . print_r($svar->getContent(), true) . "</p>";
                    
                }
        // Lyckas med att spara post utan beskrivning
        
            $content=hamtaAllaAktiviteter()->getContent();
                $aktiviteter=$content["activities"];
                $aktivitetId=$aktiviteter[0]->id;
                $postdata=['time'=>'01:00',
                'date'=>'2023-12-31',
                'activityId'=>"$aktivitetId"];
                
        // testa
                $svar= sparaNyUppgift($postdata);
                if($svar->getStatus()===200){
                $retur .="<p class='ok'>Lyckades med att spara uppgift utan beskrvining</p>";
                } else {
                    $retur .="<p class='error'>Misslyckades med att spara uppgift utan beskrvining<br>"
                    . $svar->getStatus(). "returnerades istället för förväntat 200<br>"
                    . print_r($svar->getContent(), true) . "</p>";
                }
        // Lyckas spara post med alla uppgifter  
                $postdata['description']='Detta är en testpost';
                $svar= sparaNyUppgift($postdata);
                if($svar->getStatus()===200){
                    $retur .="<p class='ok'>Lyckades med att spara uppgift med alla uppgifter</p>";
                    } else {
                        $retur .="<p class='error'>Misslyckades med att spara uppgift med alla uppgifter<br>"
                        . $svar->getStatus(). "returnerades istället för förväntat 200<br>"
                        . print_r($svar->getContent(), true) . "</p>";
                    }
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }finally{
        if($db){
            $db->rollBack();
        }
    }

    return $retur;
}

/**
 * Test för funktionen uppdatera befintlig uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_UppdateraUppgifter(): string {
    $retur = "<h2>test_UppdateraUppgifter</h2>";

    try {
        // Koppla databas + skapa transaktion
        $db=connectDb();
        $db->beginTransaction();
        
        // Hämta postdata
        $svar= hamtaSida("1");
        if($svar->getStatus()!==200){
            throw new Exception("Kunde inte hämta poster för test av Uppdatera uppgift");
        }
        $aktiviteter=$svar->getContent()->tasks;

        // Misslyckas med ogiltigt id=0
        $postdata=get_object_vars($aktiviteter[0]);
        $svar= uppdateraUppgift('0', $postdata);
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades med att hämta post med id=0, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckat test med att hämta post med id=0<br>"
            . $svar->getStatus(). "returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med ogiltigt id=sju
        $svar= uppdateraUppgift('sju', $postdata);
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades med att hämta post med id=sju, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckat test med att hämta post med id=sju<br>"
            . $svar->getStatus(). "returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med ogiltigt id=3.14
        $svar= uppdateraUppgift('3.14', $postdata);
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades med att hämta post med id=3.14, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckat test med att hämta post med id=3.14<br>"
            . $svar->getStatus(). "returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Lyckas med id som finns
        $id=$postdata['id'];
        $postdata['activityId']=(string) $postdata['activityId'];
        $postdata['description']= $postdata['description'] . "(Uppdaterad)";
        $svar= uppdateraUppgift("$id", $postdata);
        if($svar->getStatus()===200 && $svar->getContent()->result===true){
            $retur .="<p class='ok'>Uppdatera uppgift lyckades, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Misslyckat test med att uppdatera uppgift<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
    
        // Misslyckas med samma data
        $svar= uppdateraUppgift("$id", $postdata);
        if($svar->getStatus()===200 && $svar->getContent()->result===false){
            $retur .="<p class='ok'>Uppdatera uppgift misslyckades, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Uppdatera uppgift misslyckades<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }

        // Misslyckas med felaktig indata
        $postdata['time']='09:70';
        $svar= uppdateraUppgift("$id", $postdata);
        if($svar->getStatus()===400){
            $retur .="<p class='ok'>Misslyckades med att uppdatera post med felaktig indata, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Updatera uppgift med felaktig indata misslyckades<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Lyckas med saknad beskrivning
        $postdata['time']='01:30';
        unset($postdata['description']);
        $svar= uppdateraUppgift("$id", $postdata);
        if($svar->getStatus()===200){
            $retur .="<p class='ok'>Uppdatera uppgift med saknad description lyckades</p>";

        }else{
            $retur .="<p class='error'>Updatera uppgift utan description misslyckades<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        
    
        
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    } finally{
        if($db){
            $db->rollBack();
        }
    }

    return $retur;
}

function test_KontrolleraIndata(): string {
    $retur = "<h2>test_KontrolleraIndata</h2>";
        
    try {
        // Lyckas kontrollera datum
        $svar = KontrolleraIndata(['date'=>'2023-12-31']);
        if(empty($svar)){
            $retur .="<p class='ok'>Lyckades kontrollera datum</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att kontrollera datum<br>"
            . $svar[0]. " returnerades istället för förväntat tom sträng<br>"
            . print_r($svar, true) . "</p>";
        }
        
        // Misslyckas kontrollera felaktigt datum
        $svar = KontrolleraIndata(['date'=>'2023-12-37']);
        if(empty($svar)){
            $retur .="<p class='error'>Misslyckades med att kontrollera felaktigt datum<br>"
            . print_r($svar, true) . "</p>";
        } else {
            $retur .="<p class='ok'>Misslyckades kontrollera felaktigt datum</p>";
        }

        // Lyckas kontrollera tid
        $svar = KontrolleraIndata(['time'=>'01:00']);
        if(empty($svar)){
            $retur .="<p class='ok'>Lyckades kontrollera tid</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att kontrollera tid<br>"
            . $svar[0]. " returnerades istället för förväntat tom sträng<br>"
            . print_r($svar, true) . "</p>";
        }

        // Misslyckas kontrollera felaktig tid
        $svar = KontrolleraIndata(['time'=>'09:00']);
        if(empty($svar)){
            $retur .="<p class='error'>Misslyckades med att kontrollera felaktig tid</p>";
        } else {
            $retur .="<p class='ok'>Misslyckades kontrollera felaktig tid<br>"
            . print_r($svar, true) . "</p>";
        }

        // Lyckas kontrollera aktivitetsid
        $svar = KontrolleraIndata(['activityId'=>'1']);
        if(empty($svar)){
            $retur .="<p class='ok'>Lyckades kontrollera aktivitetsid</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att kontrollera aktivitetsid<br>"
            . $svar[0]. " returnerades istället för förväntat tom sträng<br>"
            . print_r($svar, true) . "</p>";
        }
          // Misslyckas kontrollera aktivitetsid
          $svar = KontrolleraIndata(['activityId'=>' ']);
          if(empty($svar)){
              $retur .="<p class='ok'>Lyckades kontrollera aktivitetsid</p>";
          } else {
              $retur .="<p class='error'>Misslyckades med att kontrollera felaktigt aktivitetsid<br>"
              . $svar[0]. " returnerades istället för förväntat tom sträng<br>"
              . print_r($svar, true) . "</p>";
          }

        
         $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}



/**
 * Test för funktionen radera uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_RaderaUppgift(): string {
    $retur = "<h2>test_RaderaUppgift</h2>";

    try {
        // Skapa transaktion
        $db=connectDb();
        $db->beginTransaction();
        // Misslyckas med att radera post med id=sju
        $svar=raderaUppgift("sju");
        if($svar->getStatus()===400){
        $retur .="<p class='ok'>Misslyckades med att radera post med id=sju, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Misslyckat med att radera post med id=sju<br>"
            . $svar->getStatus() . " returnerades istället för 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med att radera post med id=0.1
        $svar=raderaUppgift("0.1");
        if($svar->getStatus()===400){
        $retur .="<p class='ok'>Misslyckades med att radera post med id=0.1, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Misslyckat med att radera post med id=0.1<br>"
            . $svar->getStatus() . " returnerades istället för 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Misslyckas med att hämta post med id=0
        $svar=raderaUppgift("0");
        if($svar->getStatus()===400){
        $retur .="<p class='ok'>Misslyckades med att radera post med id=0, som förväntat</p>";
        }else{
            $retur .="<p class='error'>Misslyckat med att radera post med id=0<br>"
            . $svar->getStatus() . " returnerades istället för 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        // Lyckas med att radera post som finns

        // Hämta poster
        $poster= hamtasida("1");
        if($poster->getStatus()===200){
            throw new Exception('Kunde inte hämta poster');
        }
        $uppgifter=$poster->getContent()->tasks;
        // Ta fram id för första posten
        $testId=$uppgifter[0]->id;
        // Lyckas radera id för första posten
        $svar=raderaUppgift("$testId");
        if($svar->getStatus()===200 && $svar->getContent()->result===true){
            $retur .="<p class='ok'>Lyckades med att radera post, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att radera post<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        

        // Misslyckas med att radera sama id som tidigare
        $svar=raderaUppgift("$testId");
        if($svar->getStatus()===200 && $svar->getContent()->result===false){
            $retur .="<p class='ok'>Misslyckades radera post som inte finns, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att radera post som inte finns<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }
        
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    } finally {
        if($db){
            $db->rollBack();
        }
    }

    return $retur;
}
