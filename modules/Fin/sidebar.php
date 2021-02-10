<?php
hello(open_menu('Financeiro','graphic_eq','np-green'));
/*Menu para filiasi*/
$menu_sidebar_business = array(
   'fin/branches/create|Adicionar filial|add|admin,dev,editor'
);
hello(dropdown_menu('fin/branches|Filiais|account_tree|admin,dev,editor,author,collaborator',
['items'=>items_menu($menu_sidebar_business)]));


/*Menu para contas*/
$menu_sidebar_contacts = array(
   'fin/contas/create|Adicionar conta|add|admin,dev,editor'
);
hello(dropdown_menu('fin/contas|Contas|credit_card|admin',
['items'=>items_menu($menu_sidebar_contacts)]));



/*Menu para clientes e fornecedores*/

hello(dropdown_menu('fin/providers|Fornecedores|group|admin',
['items'=>items_menu(
['fin/providers/create|Adicionar fornecedor|group_add|admin,dev,editor']
)]));

hello(dropdown_menu('fin/clients|Clientes|people_alt|admin',
['items'=>items_menu(
['fin/clients/create|Adicionar cliente|group_add|admin,dev,editor']
)]));




/*Menu para movimentações*/
$menu_sidebar_n = array(
   'folder/create|Adicionar pagamento|add|admin,dev,editor'
);

hello(dropdown_menu('fin/moves|Movimentações|table_chart|admin',
['items'=>items_menu($menu_sidebar_n)]));



/*Menu para contatos*/
$menu_sidebar_products = array(
   'folder/create|Adicionar produto|add|admin,dev,editor'
);
hello(dropdown_menu('users|Relatórios|pie_chart|admin',
['items'=>items_menu($menu_sidebar_products)]));
/*Fim do Menu para contatos*/



/*Menu para contatos*/
$menu_sidebar_c = array(
   'folder/create|Adicionar contrato|add|admin,dev,editor'
);
hello(dropdown_menu('users|Contratos|content_paste|admin',
['items'=>items_menu($menu_sidebar_c)]));

/*Fim do Menu para contatos*/
hello(close_menu());
?>
