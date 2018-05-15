<?php
/*
function drawRooms(){
 
    for($x = 1; $x<= 8; $x++){
        for($y = 1; $y <=4; $y++){
              $coords = "x$x-y$y";
            echo "<style>";
            echo "#$coords";
            echo "{background: url(./clue_assets/study/$coords.jpg)}";
            echo "</style>";
            
        }
    }
    
        for($x = 11; $x<=17 ; $x++){
        for($y = 1; $y <=7; $y++){
            $coords = "x$x-y$y";
            echo "<style>";
            echo "#$coords";
            echo "{background: url(./clue_assets/study/$coords.jpg)}";
            echo "</style>";
            
        }
    }
    
}*/
/*
function drawBlack(){
    echo "<style>";
            echo "#x8-y1 ";
            echo "{background-color:white;border-color:transparent;}";
            echo "</style>";
    
}
*/
function drawGrid(){
      for($x=1; $x<=24; $x++){
           echo  '<div class="row">';
            for($y=1; $y<=25; $y++){
                echo '<div class="grid" id="x';
                echo $x;
                echo "-y";
                echo $y;
                echo '">';
                //echo "$x-$y";
                echo '</div>';
                }
               echo ' </div>';
        }   
}

function drawRooms(){
    echo '<style>';
          for($x=1; $x<=7; $x++){//study
            for($y=1; $y<=4; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }          
            }
            
            for($x=10; $x<=15; $x++){//hall
            for($y=1; $y<=7; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          
          for($x=18; $x<=25; $x++){//lounge
            for($y=1; $y<=6; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          
          for($x=1; $x<=6; $x++){//library
            for($y=7; $y<=11; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
           echo "#x7-y8 {border-color:transparent;} #x7-y8:hover {background-color:transparent;}";
          echo "#x7-y9 {border-color:transparent;} #x7-y9:hover {background-color:transparent;}";
          echo "#x7-y10 {border-color:transparent;} #x7-y10:hover {background-color:transparent;}";
      
          for($x=10; $x<=14; $x++){//centercluething
            for($y=9; $y<=15; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          
          for($x=17; $x<=25; $x++){//dining room
            for($y=10; $y<=15; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          echo "#x20-y16 {border-color:transparent;} #x20-y16:hover {background-color:transparent;}";
          echo "#x21-y16 {border-color:transparent;} #x21-y16:hover {background-color:transparent;}";
          echo "#x22-y16 {border-color:transparent;} #x22-y16:hover {background-color:transparent;}";
          echo "#x23-y16 {border-color:transparent;} #x23-y16:hover {background-color:transparent;}";
          echo "#x24-y16 {border-color:transparent;} #x24-y16:hover {background-color:transparent;}";
       
          for($x=1; $x<=6; $x++){//billiard room
            for($y=13; $y<=17; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          for($x=1; $x<=5; $x++){//conservatory 
            for($y=20; $y<=25; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          echo "#x6-y21 {border-color:transparent;} #x6-y21:hover {background-color:transparent;}";
          echo "#x6-y22 {border-color:transparent;} #x6-y22:hover {background-color:transparent;}";
          echo "#x6-y23 {border-color:transparent;} #x6-y23:hover {background-color:transparent;}";
          echo "#x6-y24 {border-color:transparent;} #x6-y24:hover {background-color:transparent;}";
          
          for($x=19; $x<=24; $x++){//kitchen 
            for($y=19; $y<=24; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          for($x=9; $x<=16; $x++){//ballroom 
            for($y=18; $y<=23; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          for($x=11; $x<=14; $x++){//ballroom 
            for($y=23; $y<=25; $y++){
                echo "#x$x-y$y {border-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
          }
          }
          
          echo '</style>';
          
}