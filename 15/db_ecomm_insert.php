<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$query = "INSERT INTO ecomm_products
            (product_code, name, description, price)
          VALUES (
            '00001', 'Trièko s logem našeho webu',
            'Toto trièko zdùrazní vaši vazbu na náš web. Naše trièka mají
            vysokou kvalitu a jsou ze 100% pøedsrážené bavlny.',
            17.95),
            ('00002','Nálepka s logem našeho webu',
            'Dejte všem vìdìt, že podporujete náš web. Nalepte si na sklo
            auta naši barevnou nálepku.',
            5.95),
            ('00003', 'Šálek s logem našeho webu',
            'S šálkem s logem našeho webu bude vaše ranní káva mnohem
            chutnìjší. Lepší bude i váš vstup do nového dne. Naše šálky mùžete
            používat v mikrovlnné troubì a také  mýt v automatické myèce.',
            8.95),
            ('00004', 'Oblek superhrdiny',
            'V nabídce jsou všechny barevné odstíny a velikosti. Tento oblek
            je úhledný, stylový a skrývá vaše nadlidské bojové schopnosti.
            Nabízíme také obleky s monogramem vyšitým na prsou.',
            99.95),
            ('00005', 'Malý univerzální hák',
            'Tento speciální hák vás dostane i z nejhorších situací a míst.
            Všimnìte si pøenosnosti a možnosti utajení.
            Hák má ovšem omezení nosnosti.',
            139.95),
            ('00006', 'Velký univerzální hák',
            'Hák pro velké zatížení, pro skoky z budovy na budovu.
            Tato verze vám dovolí bezpeènì cestovat mìstem. Vìzte však, že
            pøi hmotnosti 22 kg se vám bude obtížnì používat,
            patøíte-li k lidem s menší a lehèí postavou.',
            199.95)";
mysql_query($query, $db) or die(mysql_error($db));

echo 'Hotovo!';
?>