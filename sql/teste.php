<?php
session_start();

include_once('../conn.inc.php');

$db_path = $_SESSION[sys][login][localidade][db];
$db_user = $_SESSION[sys][login][localidade][login];
$db_pass = $_SESSION[sys][login][localidade][senha];

exit;


/*
INSERT INTO TB_OS ( ID_OS, ID_CLIENTE, ID_VENDEDOR, DT_OS, HR_OS, DT_ENTREGA, COMPRADOR, ID_STATUS, OBSERVACAO, ID_OSATEND, ID_OBJETO_CONTRATO, OBS_INTERNA, ID_TECNICO_RESP) VALUES ( 0, '5925', '13', '2017-11-23', '19:52:16', '2017-11-26', '', '7', 'TESTE DE INC', '22', '13', '2018-03-26', '54', 'alerta de algo que o vendedor achou interessante informar como privado', '1');
*/

$sql = "
INSERT INTO TB_OS (
ID_OS,
ID_CLIENTE,
ID_VENDEDOR,
DT_OS,
HR_OS, DT_ENTREGA,
ID_STATUS,
OBSERVACAO,
ID_OSATEND,
ID_OBJETO_CONTRATO,
OBS_INTERNA,
ID_TECNICO_RESP
) VALUES(
0,
6036,
13,
'2017-12-05',
'13:10:27', '2017-12-01',
7,
'',
'1',
null,
'',
1
);";

$sql1 = "INSERT INTO TB_OS (
  ID_OS, ID_CLIENTE, ID_VENDEDOR, DT_OS,
  HR_OS, DT_ENTREGA, ID_STATUS, OBSERVACAO,
  ID_OSATEND, ID_OBJETO_CONTRATO, OBS_INTERNA, ID_TECNICO_RESP
) VALUES (
  0, 6036, 13, '2017-12-05',
  '13:10:27', '2017-12-01', 6, 1,
  13, 11, null, 0);";


echo "antes";

  // use php error handling
  try {
      $dbh = ibase_connect( $db_path, $db_user, $db_pass );
      // Failure to connect
      if ( !$dbh ) {
          echo Exception( 'Failed to connect to database because: ' . ibase_errmsg(), ibase_errcode() );
      }

      $th = ibase_trans( $dbh, IBASE_READ+IBASE_COMMITTED+IBASE_REC_NO_VERSION);
      if ( !$th ) {
          echo Exception( 'Unable to create new transaction because: ' . ibase_errmsg(), ibase_errcode() );
      }

      $qs = $sql; //'select FIELD1, FIELD2, from SOMETABLE order by FIELD1';
      $qh = ibase_query( $th, $qs );

      if ( !$qh ) {
          echo Exception( 'Unable to process query because: ' . ibase_errmsg(), ibase_errcode() );
      }

      if ($iArray) {
        //gera um loop com as linhas encontradas
        $rtn = ibase_fetch_assoc($qh, IBASE_TEXT);
      } else $rtn = $qh;

      // $rows = array();
      // while ( $row = ibase_fetch_object( $qh ) ) {
      //     $rows[] = $row->NODE;
      // }

      // $rows[] now holds results. If there were any.

      // Even though nothing was changed the transaction must be
      // closed. Commit vs Rollback - question of style, but Commit
      // is encouraged. And there shouldn't <gasp>used the S word</gasp>
      // be an error for a read-only commit...

      if ( !ibase_commit( $th ) ) {
          echo Exception( 'Unable to commit transaction because: ' . ibase_errmsg(), ibase_errcode() );
      }

      // Good form would dictate error traps for these next two...
      // ...but these are the least likely to break...
      // and my fingers are getting tired.
      // Release PHP memory for the result set, and formally
      // close the database connection.
      ibase_free_result( $qh );
      ibase_close( $dbh );
  } catch ( Exception $e ) {
      echo "Caught exception: $e\n";
  }

// SELECT ID_OS FROM TB_OS\n\t\t\t\t\t\tWHERE ID_CLIENTE = '5925'\n\t\t\t\t\t\t\tAND DT_OS = '2017-11-23'\n\t\t\t\t\t\t\tAND HR_OS = '19:49:23'\n\t\t\t\t\t\t\tAND ID_VENDEDOR = '13'\n\t\t\t\t\t\t\tAND ID_TECNICO_RESP = '1'


echo "<br/>passo 2<br/>";

// Resgata id cliado para a nova OS, a partir de alguns dados únicos
$sql1 = "SELECT FIRST 15 ID_OS FROM TB_OS
          WHERE ID_CLIENTE = '6036'
            AND ID_VENDEDOR = '13'
            AND ID_TECNICO_RESP = '7'";

$sql1 = "SELECT FIRST 15 ID_OS FROM TB_OS
          ORDER BY ID_OS DESC";
$data = queryFB($sql1); // --> recupera código do cliente

while ( $row = ibase_fetch_object( $data ) ) {
    echo $row->ID_OS . " - <br/>";
}

echo "<p><hr/><pre>";
echo (($data[ID_OS]) ? "yes!!!" : "Que méca!!");

echo $sql1 . "<hr/>";

$sql1 = "SELECT first 1 ID_OS FROM TB_OS
          WHERE ID_CLIENTE = 6036
            AND ID_VENDEDOR = 13
            order by id_os desc";
$data = queryFB($sql1, 1); // --> recupera código do cliente

echo "OS #" . $data[ID_OS];


?>
