Ao invés de usar requisições de html puro (ex: <form method="POST" action="index.php">) , utilizei Fetch API do Javascript, que pode manipular a página dinamicamente e sem necessidade de Reload.

Páginas com Fetch API + SessionStorage implementadas: acessar_conta, criar_conta, e index (página principal).

Resumo das mudanças --> Agora a página envia o formulário ao PHP através de Javascript. 
O PHP, em seguida, retorna dados ao Javascript(Front-End) em formato JSON, que serão 
utilizados para manipular a página em questão (e.g configurar sessão de usuário, alterar
layout da página.

