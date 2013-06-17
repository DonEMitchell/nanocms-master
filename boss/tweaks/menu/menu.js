function menu_add_(){
   menu_count = menu_count + 1;
   var new_name = 'form_menu['+menu_count+']';
   //clone the row 0
   var r0 = $('#menu_table_title ~ tr:first').clone();
   //update some attributs
   r0.find("input[@name='form_menu[0][caption]']").attr('value','');
   r0.find("input[@name='form_menu[0][caption]']").attr('name',new_name+'[caption]');
   r0.find("select[@name='form_menu[0][cat]']").attr('name',new_name+'[cat]');
   //insert in last position
   $('#menu_table_title ~ tr:last').after(r0);
   return true;
}
function menu_add(){
   //clone first row
   var r0 = $('#menu_table_title ~ tr:first').clone();
   //update some attributs
   r0.find("input[@name='form_menu[caption][]']").attr('value','');
   menu_count = menu_count + 1;
   var rid = 'rid_'+ menu_count;
   r0.attr('id',rid);
   r0.find("img[@id='down']").unbind('onclick');
   r0.find("img[@id='down']").bind('onclick',{rowid: rid}, function(e){alert('toto'); menu_down(e.data.rowid);});//'menu_down(rid)');//attr('onclick','return menu_down("'+rid+'");');
   r0.find("img[@id='up']").bind('onclick','menu_up(rid)');//attr('onclick','return menu_up("'+rid+'");');
//   r0.find("img[@id='up']").attr('onclick','return menu_up("'+rid+'");');
   //insert in last position
   $('#menu_table_title ~ tr:last').after(r0);
   return true;
}
function exchange(i,j){
    var oTable = document.getElementById('menu_table');
    var trs = oTable.tBodies[0].getElementsByTagName("tr");

    if(i >= 0 && j >= 0 && i < trs.length && j < trs.length)
    {
        if(i == j+1) {
            oTable.tBodies[0].insertBefore(trs[i], trs[j]);
        } else if(j == i+1) {
            oTable.tBodies[0].insertBefore(trs[j], trs[i]);
        } else {
            var tmpNode = oTable.tBodies[0].replaceChild(trs[i], trs[j]);
            if(typeof(trs[i]) != "undefined") {
                oTable.tBodies[0].insertBefore(tmpNode, trs[i]);
            } else {
                oTable.appendChild(tmpNode);
            }
        }
    }
    else {
        alert("Invalid Values!");
    }
}
function menu_up(rowid){
    var oTable = document.getElementById('menu_table');
    var trs = oTable.tBodies[0].getElementsByTagName("tr");
    var i = -1;
    //find index of row
    for (var j=1; j < trs.length; j++){
        if(trs.item(j).id == rowid){
            i = j;
        }
    }
    //exchange row with prev row
    if (i>1 && i<(trs.length)){
        exchange(i-1,i);
    }
    return true;
}
function menu_down(rowid){
    alert(rowid);
    var oTable = document.getElementById('menu_table');
    var trs = oTable.tBodies[0].getElementsByTagName("tr");
    var i = -1;
    //find index of row
    for (var j=1; j < trs.length; j++){
        if(trs.item(j).id == rowid){
            i = j;
        }
    }
    //exchange row with next row
    if (i>0 && i<(trs.length - 1)){
        exchange(i,i+1);
    }
    return true;
}