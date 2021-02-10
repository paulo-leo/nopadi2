<?php
hello(open_menu('Gráficos','pie_chart','np-pink'));
/*Menu para filiasi*/

hello(dropdown_menu('chart|Gráficos|list|admin,dev,editor,author,collaborator',['active'=>'np-white']));

hello(dropdown_menu('chart/create|Criar gráfico|playlist_add|admin,dev,editor,author,collaborator',['active'=>'np-white']));


hello(close_menu());
?>
