<?php
  session_start();

  $oObj = $_REQUEST[data];
  $iQtd = 0;

  if (($oObj[login] == "") or ($oObj[senha] == "") or ($oObj[localidade] == "")) {
    echo null;
    return "";
    exit;
  }

  // $oObj[login] = "thiago soares";
  // $oObj[senha] = "123mudar";
  // $oObj[localidade] = "ctba";

  require( '../conn.inc.php' );


  // $aRtn =  Array(code => $sStatus, data => json_encode($data_rtn), msg => "$sMsg");  /* - $sql !! ($sLogin . $sSenha)"*/

  $_SESSION[sys][FBConn] = array(
                                  'ctba' => ['cidade' => 'Curitiba',
                                                 'db'    => '192.168.0.2:C:\Program Files (x86)\CompuFour\Clipp\Base\CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1', '12','15','52','61'],
                                                 'cabecalho' => "  OMNI INFORMÁTICA LTDA<br />
                                                                   CNPJ: 81.655.441/0001-23 Insc. Estadual: 101.972.58-51<br />
                                                                   Avenida Cândido de Abreu, 526 Loja 7 - Centro Cívico<br />
                                                                   80530-905 - Curitiba - PR<br />
                                                                   Fone: (41) 3888-7679<br />
                                                                   Site: www.omniinformatica.com.br / Email: omni@omniinformatica.com.br"
                                            ],
                                  'clbo' => ['cidade' => 'Colombo',
                                                 'db'    => 'localhost:/var/www/html/omni/oCtrl/db/CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1', '12','15','52','61'],
                                                 'cabecalho' => "  OMNI COLOMBO TECNOLOGIA LTDA ME <br />
                                                                   CNPJ: 20.174.797/0001-50 Insc. Estadual: 906.629.08-99 <br />
                                                                   Avenida Ayrton Senna da Silva, 500 - Loja 2 - Gleba Fazenda Palhano  <br />
                                                                   86050-460 - Londrina / PR <br />
                                                                   Fone: (43) 3027-7679 <br />
                                                                   Site: www.omniinformatica.com.br / Email: omni@omniinformatica.com.br"
                                            ],
                                  'lda'  => ['cidade' => 'Londrina',
                                                 'db'    => '192.168.0.5:C:\Program Files\CompuFour\Clipp\Base\CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1', '1','4','5'],
                                                 'cabecalho' => "  OMNI LONDRINA TECNOLOGIA LTDA ME <br />
                                                                   CNPJ: 20.174.797/0001-50 Insc. Estadual: 906.629.08-99 <br />
                                                                   Avenida Ayrton Senna da Silva, 500 - Loja 2 - Gleba Fazenda Palhano  <br />
                                                                   86050-460 - Londrina / PR <br />
                                                                   Fone: (43) 3027-7679 <br />
                                                                   Site: www.omniinformatica.com.br / Email: omni@omniinformatica.com.br"
                                            ],
                                  'ntl'  => ['cidade' => 'Natal',
                                                 'db'    => '192.168.2.2:C:\Program Files (x86)\CompuFour\Clipp\Base\CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1'],
                                                 'cabecalho' => "  OMNI NATAL TECNOLOGIA LTDA ME <br />
                                                                   CNPJ: 25.306.048/0001-53 Insc. Estadual: 20.454.742-3 <br />
                                                                   Avenida Amintas Barros, 3700 – Loja 1B e 2B C.T.C  - Lagoa Nova  <br />
                                                                   59075-810 - Natal / RN <br />
                                                                   Fone: (84) 3025-7679 <br />
                                                                   Site: www.omniinformatica.com.br / Email: omni@omniinformatica.com.br"
                                            ]
                                );

  $_SESSION[sys][login] = array(
                                 'id' => 0,
                                 'usuario' => 'Indefinido',
                                 'nivel' => '0',
                                 'funcao' => '-',
                                 'login' => '',
                                 'senha' => '',
                                 'acesso_em' => date('d-m-Y H:i:s'),
                                 'localidade' => $_SESSION[sys][FBConn][$oObj[localidade]]
                               );

  //Instruções SQL
 	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME, r.SENHA, r.STATUS, r.CARGO, r.APELIDO
           FROM V_FUNCIONARIOS r ".
        //  " WHERE r.NOME = '". strtoupper( $oObj[login] )."'";
         " WHERE r.SENHA = '". strtoupper( md5( strtoupper( $oObj[login] . $oObj[senha] ) ) )."'";

  $data = queryFB($sql, 1);

  // Se encontrado
  if ($data) {
    // if ($data[STATUS])
      {
        if ($oObj[localidade] == "clbo"){
            $_SESSION[sys][login] = array(
                                         'id' => $data[ID_FUNCIONARIO],
                                         'usuario' => "{$data[NOME]}",
                                         'apelido' => "{$data[APELIDO]}",
                                         'avatar' => strtoupper($data[NOME]).".jpg",
                                         'nivel' => '0',
                                         'status' => "{$data[STATUS]}",
                                         'funcao' => "{$data[CARGO]}",
                                         'login' => "{$oObj[login]}",
                                         'senha' => "{$oObj[senha]}",
                                         'acesso_em' => date('d-m-Y H:i:s'),
                                         'localidade' => $_SESSION[sys][FBConn][$oObj[localidade]]
                                       );
        } else {
            $_SESSION[sys][login] = array(
                                         'id' => $data[ID_FUNCIONARIO],
                                         'usuario' => utf8_encode($data[NOME]),
                                         'apelido' => utf8_encode($data[APELIDO]),
                                         'avatar' => (file_exists("../assets/images/users/".strtoupper(utf8_encode($data[NOME])).".jpg") ? strtoupper(utf8_encode($data[NOME])) . ".jpg" : "user.png"),
                                         'nivel' => '0',
                                         'status' => $data[STATUS],
                                         'funcao' => utf8_encode($data[CARGO]),
                                         'login' => $oObj[login],
                                         'senha' => $oObj[senha],
                                         'acesso_em' => date('d-m-Y H:i:s'),
                                         'localidade' => $_SESSION[sys][FBConn][$oObj[localidade]]
                                       );
        };


        if (!file_exists("../assets/images/users/".$_SESSION[sys][login]['avatar']) ) {
          $_SESSION[sys][login]['avatar'] = "user.jpg";
        }

        $iQtd = 1;
      };
  };

  // print_r($_SESSION[sys][login]);

  echo $data[ID_FUNCIONARIO];
  // echo json_encode($data[ID_FUNCIONARIO]);
  // echo Array(code => $iQtd, data => $_SESSION[sys][login], msg => "logar() - <hr>" . $sql);

?>
