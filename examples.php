<?php include_once('class/Sqlexpress.php'); // Objeto já instanciado:: $sql

# Seleção de dados [SELECT]: Recebe os campos a serem selecionados em um array no terceiro parâmetro
$sql->query('select', 'users', array('*'));
$sql->where('id', 7);


# Inserção de dados [INSERT]: Recebe todos os valores passados em POST, e sincroniza automático com os campos da tabela do banco de dados. Terceiro parâmetro = null ou array com valores do posts à serem retirados.
$sql->query('insert', 'users', null);

# Atualização de dados [UPDATE]: Recebe um array no terceiro parâmetro com os dados a serem atualizados.
$sql->query('update', 'users', $dados = array('login'=>'john', 'password'=>'123456'));

# Exclusão de dados [DELETE]: Recebe apenas o nome da tabela a ser manipulada, com o terceiro parâmetro sendo null.
$sql->query('delete', 'users', null);
$sql->where('id', 9);

# Execução de query: Executa a query que está montada no objeto
$sql->run();

# Listagem de dados [FETCH_ASSOC]: Retorna um array de objetos, listando os valores de uma query de seleção
 $sql->query('select', 'users', array('*'));
 $array = $sql->assoc();



### Não executar essa view, apenas para exemplificar a execução da biblioteca ###