<?php
$menu_tweak = new Tweak( lt("Menu builder") );
$menu_tweak->author("GarfieldFr");
$menu_tweak->description("Build a menu");
$menu_tweak->addInterface('menu_build');
$menu_tweak->addTweak('menu-show', 'menu_show');
$menu_tweak->addTweak('admin-head-content', 'menu_js');
$menu_tweak->addTweak('admin-page', 'menu_save');
/**
* This is menu generator used in main template
*/
function menu_show(){
   $form_menu = getDetails('menu_cfg');
   if ((!isset($form_menu))or(count($form_menu)==0)) return;
?>
   <ul class="menu">
<?php
   foreach($form_menu as $k=>$item) {
?>
   <li><a href="#nogo" class="drop" ><?php echo $item['caption'];?><!--[if IE 7]><!--></a><!--<![endif]-->
      <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul><?php show_links($item['cat'],'<li class="submenu">%s</li>'."\n"); ?></ul>
      <!--[if lte IE 6]></td></tr></table></a><![endif]-->
   </li>
<?php
   }
}
/**
* This is form to edit menu
*/
function menu_build(){
   include(dirname(__FILE__).'/menu/top_help.html');
   $cdt = getDetails('cats');
   foreach( $cdt as $cN=>$cSC ) $catSelectList[$cN] = $cN;
   $form_menu = getDetails('menu_cfg');
?>
<form action="#" method="post" name="form_menu">
<table id="menu_table" class="pageListTable">
   <tbody>
   <tr id="menu_table_title" class="th"><th><?php echo lt('Menu Caption');?></th><th><?php echo lt('Category');?></th></tr>
<?php
   if(isset($form_menu)){
      foreach($form_menu as $k=>$item){
         $rid = 'rid_'.$k;
         echo '<tr id="'.$rid.'"><td><input type="text" name="form_menu[caption][]" value="'.$item["caption"].'" /></td>'."\n";
         echo '    <td>'.html_select( 'form_menu[cat][]',$catSelectList,$item["cat"])."</td></tr>\n";
      }
   }else{
      echo '<tr id="rid_0"><td><input type="text" name="form_menu[caption][]" value="" /></td>'."\n";
      echo '    <td>'.html_select( 'form_menu[cat][]',$catSelectList,$item["cat"])."</td></tr>\n";
   } ?>
   </tbody>
</table>
<input type="button" value="<?php echo lt('Add'); ?>" onclick="return menu_add();" />
<input type="submit" value="<?php echo lt('Save'); ?>" />
</form>
<?php
    include(dirname(__FILE__).'/menu/css_help.html');
}
/**
* Insert javascript and CSS needed by tweak
*/
function menu_js(){
   global $menu_tweak;
   if($_GET['tweak']!=$menu_tweak->tweakName)
      return;
   $menu_css = NANO_TWEAKS_DIR . 'menu/menu.css';
   $menu_js = NANO_TWEAKS_DIR . 'menu/menu.js';
   echo "<link rel=\"stylesheet\" href=\"$menu_css\" />\n";
   $form_menu = getDetails('menu_cfg');
   if(isset($form_menu)){
      $menu_count = count($form_menu);
   }else{
      $menu_count = 0;
   }
   echo "<script type=\"text/javascript\"> var menu_count = $menu_count ;</script>\n";
   echo "<script src=\"$menu_js\" type=\"text/javascript\"></script>\n";
}
/**
* Save the menu configuration
*/
function menu_save(){
   global $menu_tweak;
   if($_GET['tweak']!=$menu_tweak->tweakName)
      return;

   if (isset($_POST['form_menu'])){
      foreach($_POST['form_menu']['caption'] as $k=>$item){
         if (!empty($item)){
            $form_menu[]=array('caption'=>$item,'cat'=> $_POST['form_menu']['cat'][$k]);
         }
      }
      setDetails('menu_cfg',$form_menu);
      savepages();
   }
}
?>
