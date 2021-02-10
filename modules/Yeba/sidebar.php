<?php
hello(open_menu('CRM','business','np-indigo'));

/*Menu para empresas*/
$menu_sidebar_business = array(
   'crm/accounts/create|Adicionar empresa|add|admin,dev,editor'
);
hello(dropdown_menu('crm/accounts|Empresas|business|admin,dev,editor,author,collaborator',
['items'=>items_menu($menu_sidebar_business)]));
/*Fim do Menu para empresas*/


/*Menu para contatos*/
$menu_sidebar_contacts = array(
   'crm/contacts/create|Adicionar contato|add|admin,dev,editor'
);
hello(dropdown_menu('crm/contacts|Contatos|call|admin',
['items'=>items_menu($menu_sidebar_contacts)]));

/*Fim do Menu para contatos*/


/*Menu para negócios*/
$menu_sidebar_n = array(
   'crm/business/create|Adicionar Negócio|add|admin,dev,editor'
);
hello(dropdown_menu('crm/business|Negócios|business_center|admin',
['items'=>items_menu($menu_sidebar_n)]));

/*Fim do Menu para contatos*/


/*Menu para produtos*/
$menu_sidebar_products = array(
   'folder/create|Adicionar produto|add|admin,dev,editor'
);
hello(dropdown_menu('users|Produtos|shopping_cart|admin',
['items'=>items_menu($menu_sidebar_products)]));
/*Fim do Menu para produtos*/


/*Menu para propostas*/
$menu_sidebar_p = array(
   'crm/proposals/create|Adicionar proposta|add|admin,dev,editor'
);
hello(dropdown_menu('crm/proposals|Propostas|receipt_long|admin',
['items'=>items_menu($menu_sidebar_p)]));
/*Fim do Menu para propostas*/

/*Menu para contatos*/
$menu_sidebar_c = array(
   'folder/create|Adicionar contrato|add|admin,dev,editor'
);
hello(dropdown_menu('users|Contratos|content_paste|admin',
['items'=>items_menu($menu_sidebar_c)]));

/*Fim do Menu para contatos*/
hello(close_menu());
?>
