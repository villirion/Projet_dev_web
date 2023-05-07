<?php
    session_start();
    //creer le catalogue
    $data = fopen("data/catalogue.csv", "r");
    $bulbes = fopen("php/bulbes.html", "w");
    $massif = fopen("php/massif.html", "w");
    $rosiers = fopen("php/rosiers.html", "w");
    if ($data and $bulbes and $massif and $rosiers) {
        $tabHead = "
        <table>
            <tr>
                <td>image</td> <td>ref</td> <td>description</td> <td>prix</td> <td></td> <td class = 'stock'>stock</td>
            </tr>";
        fwrite($bulbes, $tabHead);
        fwrite($massif, $tabHead);
        fwrite($rosiers, $tabHead);
        while (($line = fgets($data)) !== false) {
            $tableau = explode(',', $line);
            $tabLigne = '
            <tr>
                <td><img src=' . $tableau[1] . ' /></td> <td>' . $tableau[2] . '</td> 
                <td>' . $tableau[3] . ' </td> <td>' . $tableau[4] . '</td> 
                <td>
                <form action= "" method= "post">
                    <button type= "button" onclick= "minus(this);" id= "' . $tableau[2] . '">-</button>
                    <input type= "number" name= "' . $tableau[2] . '" value= "0" min= "0" max= "' . $tableau[5] . '">
                    <button type= "button" onclick= "plus(this);" id= "' . $tableau[2] . '">+</button>
                    <br><input type= "submit" name= "ajoutPanier" value= "Ajouter au panier" />
                </form>
                </td>
                <td class =  "stock ">' . $tableau[5] . '</td>
            </tr>';
            if ($tableau[0] == "bulbes") {
                fwrite($bulbes, $tabLigne);
            }
            if ($tableau[0] == "massif") {
                fwrite($massif, $tabLigne);
            }
            if ($tableau[0] == "rosiers") {
                fwrite($rosiers, $tabLigne);
            }
        }    
        $tabFoot = "
        </table> 
        <input type='button' name='stock' value='Afficher stock' onclick='toggleStock();' />
        <script> 
            function toggleStock() { 
                let stock = document.getElementsByClassName('stock');
                let i=stock.length; 
                if(stock[0].style.visibility == 'hidden'){
                    while(i--){
                        stock[i].style.visibility = 'visible'
                    }
                } else {
                    while(i--){
                        stock[i].style.visibility = 'hidden'
                    }
                }
            } 
            toggleStock();
            function plus(e){
                fieldName = e.getAttribute('id');
                let allInput = document.getElementsByTagName('input');
                let i=allInput.length; 
                while(i--){
                    if (allInput[i].getAttribute('name') == fieldName){
                        break;
                    }
                }
                let currentVal = allInput[i].value;
                let max =  allInput[i].getAttribute('max');
                currentVal++;
                if(currentVal < max) {
                    allInput[i].value++;
                }
            };

            function minus(e){
                fieldName = e.getAttribute('id');
                let allInput = document.getElementsByTagName('input');
                let i=allInput.length; 
                while(i--){
                    if (allInput[i].getAttribute('name') == fieldName){
                        break;
                    }
                }
                let currentVal = allInput[i].value;
                let min =  allInput[i].getAttribute('min');
                if (currentVal > min) {
                    allInput[i].value--;
                }
            };

        </script>";
        fwrite($bulbes, $tabFoot);
        fwrite($massif, $tabFoot);
        fwrite($rosiers, $tabFoot);
    }
    fclose($data);
    fclose($bulbes);
    fclose($massif);
    fclose($rosiers);
?>
