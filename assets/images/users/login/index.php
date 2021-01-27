<?php
  session_start();

  $oObj = $_REQUEST[data];

  if (($oObj[login] == "") or ($oObj[senha] == "") or ($oObj[localidade] == "")) {
    echo null;
    // return "";
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
                                                 'master' => ['-1', '12','15','52','61'] ],
                                  'lda'  => ['cidade' => 'Londrina',
                                                 'db'    => '192.168.0.5:C:\Program Files\CompuFour\Clipp\Base\CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1', '1','4','5'] ],
                                  'ntl'  => ['cidade' => 'Natal',
                                                 'db'    => '192.168.2.2:C:\Program Files (x86)\CompuFour\Clipp\Base\CLIPP.FDB',
                                                 'login' => 'SYSDBA',
                                                 'senha' => 'masterkey',
                                                 'master' => ['-1'] ]
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
//          " WHERE r.NOME = '". strtoupper( $oObj[login] )."'";
         " WHERE r.SENHA = '". strtoupper( md5( strtoupper( $oObj[login] . $oObj[senha] ) ) )."'";

  $data = queryFB($sql, 1);

  // Se encontrado
  if ($data[ID_FUNCIONARIO]) {
    // if ($data[STATUS])
      $_SESSION[sys][login] = array(
                                     'id' => $data[ID_FUNCIONARIO],
                                     'usuario' => utf8_encode($data[NOME]),
                                     'apelido' => utf8_encode($data[APELIDO]),
                                     'avatar' => (file_exists("../assets/images/users/".strtoupper(utf8_encode($data[NOME])).".jpg") ? strtoupper(utf8_encode($data[NOME])) . ".jpg" : "user.jpg"),
                                     'nivel' => '0',
                                     'status' => $data[STATUS],
                                     'funcao' => utf8_encode($data[CARGO]),
                                     'login' => $oObj[login],
                                     'senha' => $oObj[senha],
                                     'acesso_em' => date('d-m-Y H:i:s'),
                                     'localidade' => $_SESSION[sys][FBConn][$oObj[localidade]]
                                   );
  }

  echo json_encode($data[NOME]);
?>
