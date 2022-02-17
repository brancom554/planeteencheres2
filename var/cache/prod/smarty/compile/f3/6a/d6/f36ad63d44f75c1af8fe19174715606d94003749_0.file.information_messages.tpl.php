<?php
/* Smarty version 3.1.34-dev-7, created on 2020-12-10 03:00:15
  from 'E:\xampp\htdocs\ytc_templates\prestashop\sp_topdeals_1770\sp_admin\themes\new-theme\template\components\layout\information_messages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fd1d58f92cbc7_78510191',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f36ad63d44f75c1af8fe19174715606d94003749' => 
    array (
      0 => 'E:\\xampp\\htdocs\\ytc_templates\\prestashop\\sp_topdeals_1770\\sp_admin\\themes\\new-theme\\template\\components\\layout\\information_messages.tpl',
      1 => 1607572732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fd1d58f92cbc7_78510191 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['informations']->value) && count($_smarty_tpl->tpl_vars['informations']->value) && $_smarty_tpl->tpl_vars['informations']->value) {?>
  <div class="bootstrap">
    <div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <ul id="infos_block" class="list-unstyled">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['informations']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
          <li><?php echo $_smarty_tpl->tpl_vars['info']->value;?>
</li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </ul>
    </div>
  </div>
<?php }
}
}
